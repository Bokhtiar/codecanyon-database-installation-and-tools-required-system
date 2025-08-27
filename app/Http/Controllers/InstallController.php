<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InstallController extends Controller
{
    public function welcome()
    {
        return view('install.step1_welcome');
    }

    public function requirements()
    {
        $requirements = [
            'PHP >= 8.1' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'PDO' => extension_loaded('pdo'),
            'Mbstring' => extension_loaded('mbstring'),
            'Storage Writable' => is_writable(storage_path()),
        ];
        return view('install.step2_requirements', compact('requirements'));
    }

    public function envForm()
    {
        // Default database configuration from Docker Compose
        $defaultConfig = [
            'db_host' => '127.0.0.1',
            'db_name' => 'cms',
            'db_user' => 'cm_user',
            'db_pass' => 'cms_secret',
        ];
        
        return view('install.step3_env', compact('defaultConfig'));
    }

    public function saveEnv(Request $request)
    {
        try {
            Log::info('saveEnv method started', $request->all());
            
            $request->validate([
                'db_host' => 'required|string',
                'db_name' => 'required|string',
                'db_user' => 'required|string',
                'db_pass' => 'nullable|string',
            ]);

            $data = $request->only(['db_host', 'db_name', 'db_user', 'db_pass']);
            Log::info('Validation passed, data:', $data);
            
            // 1. Update .env file - Dynamic configuration
            $this->setEnv([
                'DB_HOST' => $data['db_host'],
                'DB_DATABASE' => $data['db_name'],
                'DB_USERNAME' => $data['db_user'],
                'DB_PASSWORD' => $data['db_pass'] ?? '',
                'DB_CONNECTION' => 'mysql',
                'DB_PORT' => '3308', // Docker mapped port
            ]);
            Log::info('Environment file updated');

            // 2. Database creation using PDO
            // Detect environment and use appropriate connection
            $connectionHost = $this->detectConnectionHost($data['db_host']);
            $connectionPort = $this->detectConnectionPort($data['db_host']);
            
            Log::info("Using connection: host={$connectionHost}, port={$connectionPort}");
            
            $rootPdo = new \PDO(
                "mysql:host={$connectionHost};port={$connectionPort};charset=utf8mb4",
                'root',
                'root', // Docker compose MYSQL_ROOT_PASSWORD
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            Log::info('Root PDO connection established');
        
            // Create database
            $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$data['db_name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            Log::info('Database created successfully');
        
            // Create user & grant privileges (only if user doesn't exist)
            try {
                Log::info('Starting user creation process');
                $rootPdo->exec("CREATE USER IF NOT EXISTS '{$data['db_user']}'@'%' IDENTIFIED BY '{$data['db_pass']}'");
                Log::info('User created successfully');
                $rootPdo->exec("GRANT ALL PRIVILEGES ON `{$data['db_name']}`.* TO '{$data['db_user']}'@'%'");
                Log::info('Privileges granted successfully');
                $rootPdo->exec("FLUSH PRIVILEGES");
                Log::info('Privileges flushed successfully');
                Log::info('User created and privileges granted');
            } catch (\PDOException $e) {
                Log::warning('User might already exist: ' . $e->getMessage());
                // Try to grant privileges anyway
                try {
                    $rootPdo->exec("GRANT ALL PRIVILEGES ON `{$data['db_name']}`.* TO '{$data['db_user']}'@'%'");
                    $rootPdo->exec("FLUSH PRIVILEGES");
                    Log::info('Privileges granted to existing user');
                } catch (\PDOException $e2) {
                    Log::warning('Failed to grant privileges: ' . $e2->getMessage());
                }
            }
        
            // 3. Clear config cache to reload new .env
            Log::info('Starting config cache clear');
            Artisan::call('config:clear');
            Log::info('Config cache cleared');
            
            // 4. Redirect to database setup step
            Log::info('Redirecting to database setup step');
            return redirect('/install/database')->with('success', 'Database configuration saved successfully! Now setting up database...');
        } catch (\Exception $e) {
            Log::error('Error in saveEnv: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($e instanceof \PDOException) {
                return back()->withInput()->withErrors(['db_error' => 'Database creation failed: ' . $e->getMessage()]);
            }
            
            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function dbSetup()
    {
        try {
            Log::info('dbSetup method started');
            
            // Test database connection (config is handled globally)
            $pdo = DB::connection()->getPdo();
            Log::info('Database connection successful');
            
            // Run migrations
            Log::info('Starting migrations...');
            
            // Check if tables exist
            try {
                $tables = DB::select('SHOW TABLES');
                if (count($tables) > 0) {
                    Log::info('Tables already exist, using migrate:fresh');
                    Artisan::call('migrate:fresh', ['--force' => true]);
                } else {
                    Log::info('No tables exist, using migrate');
                    Artisan::call('migrate', ['--force' => true]);
                }
            } catch (\Exception $e) {
                Log::warning('Error checking tables: ' . $e->getMessage());
                Log::info('Using migrate:fresh as fallback');
                Artisan::call('migrate:fresh', ['--force' => true]);
            }
            
            Log::info('Migrations completed successfully');
            
            return view('install.step4_admin');
            
        } catch (\Exception $e) {
            Log::error('Error in dbSetup: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Database setup failed: ' . $e->getMessage());
        }
    }

    public function createAdmin(Request $request)
    {
        try {
            Log::info('createAdmin method started');
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);
            
            // Test database connection (config is handled globally)
            DB::connection()->getPdo();
            Log::info('Database connection successful');
            
            // Create admin user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_active' => true,
            ]);

            // Ensure admin role exists and assign it
            try {
                // Check if admin role exists, if not create it
                if (!Role::where('name', 'admin')->exists()) {
                    Log::info('Admin role not found, creating it...');
                    Role::create([
                        'name' => 'admin',
                        'display_name' => 'Administrator',
                        'description' => 'System administrator with full access',
                        'guard_name' => 'web'
                    ]);
                    Log::info('Admin role created during installation');
                }
                
                // Assign admin role to user
                $user->assignRole('admin');
                Log::info('Admin role assigned to user successfully');
            } catch (\Exception $e) {
                Log::error('Failed to create/assign admin role: ' . $e->getMessage());
                // Try to create basic permissions and role as fallback
                try {
                    Log::info('Attempting fallback permission creation...');
                    $this->createBasicPermissions();
                    // Try to assign role again
                    $user->assignRole('admin');
                    Log::info('Admin role assigned after fallback creation');
                } catch (\Exception $e2) {
                    Log::error('Fallback also failed: ' . $e2->getMessage());
                    // Continue anyway as the user is created
                }
            }
            
            Log::info('Admin user created successfully');
            
            // Run seeders to populate default settings and roles/permissions
            try {
                // First seed basic settings
                Artisan::call('db:seed', ['--class' => 'SettingsSeeder', '--force' => true]);
                Log::info('Settings seeded successfully');
                
                // Then seed roles and permissions
                Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder', '--force' => true]);
                Log::info('Roles and permissions seeded successfully');
                
            } catch (\Exception $e) {
                Log::warning('Seeder failed: ' . $e->getMessage());
                // Try to create basic permissions manually if seeder fails
                try {
                    $this->createBasicPermissions();
                    Log::info('Basic permissions created manually');
                } catch (\Exception $e2) {
                    Log::warning('Failed to create basic permissions manually: ' . $e2->getMessage());
                }
            }
            
            // Mark installation as complete
            $this->setEnv(['APP_INSTALLED' => 'true']);
            Log::info('Installation marked as complete');
            
            // Clear all caches to ensure new configuration is loaded
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Log::info('All caches cleared');
            
            return redirect('/install/finish');
            
        } catch (\Exception $e) {
            Log::error('Error in createAdmin: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to create admin user: ' . $e->getMessage());
        }
    }

    public function finish()
    {
        // Verify installation is complete
        try {
            // Check if database is accessible
            DB::connection()->getPdo();
            
            // Check if admin user exists (using Spatie roles)
            $adminUser = User::role('admin')->first();
            if (!$adminUser) {
                Log::warning('No admin user found with admin role');
                return redirect('/install')->with('error', 'Installation incomplete. Admin user not found. Please try again.');
            }
            
            // Check if roles and permissions exist
            if (!Role::where('name', 'admin')->exists()) {
                Log::warning('Admin role not found');
                return redirect('/install')->with('error', 'Installation incomplete. Admin role not found. Please try again.');
            }
            
            // Check if basic permissions exist
            if (!Permission::where('name', 'view_dashboard')->exists()) {
                Log::warning('Basic permissions not found');
                return redirect('/install')->with('error', 'Installation incomplete. Basic permissions not found. Please try again.');
            }
            
            Log::info('Installation verification successful');
            return view('install.step5_finish');
            
        } catch (\Exception $e) {
            Log::error('Installation verification failed: ' . $e->getMessage());
            return redirect('/install')->with('error', 'Installation verification failed. Please check your configuration.');
        }
    }

    /**
     * Check if system is properly installed
     */
    public static function isSystemInstalled()
    {
        try {
            // Check if APP_INSTALLED is set
            if (env('APP_INSTALLED') !== 'true') {
                return false;
            }
            
            // Check if database is accessible
            DB::connection()->getPdo();
            
            // Check if essential tables exist
            if (!Schema::hasTable('users')) {
                return false;
            }
            
            // Check if roles table exists (Spatie)
            if (!Schema::hasTable('roles')) {
                return false;
            }
            
            // Check if admin user exists with admin role
            try {
                $adminUser = User::role('admin')->first();
                if (!$adminUser) {
                    return false;
                }
            } catch (\Exception $e) {
                // If Spatie is not working, fallback to basic check
                $adminUser = DB::table('users')->first();
                if (!$adminUser) {
                    return false;
                }
            }
            
            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }

    private function setEnv(array $data)
    {
        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        foreach ($data as $key => $value) {
            $pattern = "/^$key=.*$/m";
            $replacement = "$key=$value";
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $replacement, $env);
            } else {
                $env .= "\n$replacement";
            }
        }
        file_put_contents($envPath, $env);
    }

    private function detectConnectionHost($dbHost)
    {
        // Check if we're running inside Docker container
        if (file_exists('/.dockerenv')) {
            // Inside Docker container - use Docker service name
            if ($dbHost === '127.0.0.1' || $dbHost === 'localhost') {
                return 'db'; // Docker service name
            }
            return $dbHost;
        } else {
            // Outside Docker - use host machine connection
            if ($dbHost === 'db') {
                return '127.0.0.1'; // Docker container on host
            }
            return $dbHost;
        }
    }

    private function detectConnectionPort($dbHost)
    {
        // Check if we're running inside Docker container
        if (file_exists('/.dockerenv')) {
            // Inside Docker container - use internal port
            return 3306;
        } else {
            // Outside Docker - use mapped port
            if ($dbHost === 'db' || $dbHost === '127.0.0.1') {
                return 3308; // Docker mapped port
            }
            return 3306; // Default MySQL port
        }
    }

    /**
     * Create basic permissions if seeder fails
     */
    private function createBasicPermissions()
    {
        try {
            // Create basic permissions
            $permissions = [
                'view_dashboard',
                'view_users', 'create_users', 'edit_users', 'delete_users', 'activate_users', 'deactivate_users', 'assign_roles',
                'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_roles',
                'view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions', 'assign_permissions',
                'view_settings', 'edit_settings',
                'view_licenses', 'create_licenses', 'edit_licenses', 'delete_licenses', 'verify_licenses', 'activate_licenses', 'deactivate_licenses',
            ];

            foreach ($permissions as $permission) {
                if (!Permission::where('name', $permission)->exists()) {
                    Permission::create([
                        'name' => $permission,
                        'display_name' => ucwords(str_replace('_', ' ', $permission)),
                        'guard_name' => 'web'
                    ]);
                }
            }

            // Create admin role if it doesn't exist
            if (!Role::where('name', 'admin')->exists()) {
                $adminRole = Role::create([
                    'name' => 'admin',
                    'display_name' => 'Administrator',
                    'description' => 'System administrator with full access',
                    'guard_name' => 'web'
                ]);

                // Assign all permissions to admin role
                $adminRole->givePermissionTo($permissions);
            }

            Log::info('Basic permissions and admin role created successfully');
        } catch (\Exception $e) {
            Log::error('Failed to create basic permissions: ' . $e->getMessage());
            throw $e;
        }
    }
}
