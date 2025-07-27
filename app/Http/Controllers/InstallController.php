<?php

namespace App\Http\Controllers;

use Schema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            // dd($request->all());

            $data = $request->only(['db_host', 'db_name', 'db_user', 'db_pass']);
            Log::info('Validation passed, data:', $data);
            
            // 1. Update .env ফাইল - Dynamic configuration
            $this->setEnv([
                'DB_HOST' => $data['db_host'], // ✅ User input ব্যবহার করি
                'DB_DATABASE' => $data['db_name'],
                'DB_USERNAME' => $data['db_user'],
                'DB_PASSWORD' => $data['db_pass'] ?? '',
                'DB_CONNECTION' => 'mysql',
                'DB_PORT' => '3308', // ✅ Docker mapped port
            ]);
            Log::info('Environment file updated');

            // 2. Database তৈরি করার চেষ্টা PDO দিয়ে
            // Detect environment and use appropriate connection
            $connectionHost = $this->detectConnectionHost($data['db_host']);
            $connectionPort = $this->detectConnectionPort($data['db_host']);
            
            Log::info("Using connection: host={$connectionHost}, port={$connectionPort}");
            
            $rootPdo = new \PDO(
                "mysql:host={$connectionHost};port={$connectionPort};charset=utf8mb4",
                'root',
                'root', // এটা docker-compose.yml এর MYSQL_ROOT_PASSWORD
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
            Log::info('Root PDO connection established');
        
            // Create DB
            $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$data['db_name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            Log::info('Database created');
        
            // Create User & Grant (only if user doesn't exist)
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
            }
        
            // 3. Clear config cache যাতে নতুন .env পড়ে
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
            
            return back()->with('error', $e->getMessage());
        }
    }

    public function createAdmin(Request $request)
    {
        try {
            Log::info('createAdmin method started');
            
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            
            // Test database connection (config is handled globally)
            DB::connection()->getPdo();
            Log::info('Database connection successful');
            
            // Create admin user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            Log::info('Admin user created successfully');
            
            // Mark installation as complete
            $this->setEnv(['APP_INSTALLED' => 'true']);
            Log::info('Installation marked as complete');
            
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
        return view('install.step5_finish');
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
}
