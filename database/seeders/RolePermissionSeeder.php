<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $allPermissions = [
            // Dashboard
            'view_dashboard',
            
            // User Management
            'view_users', 'create_users', 'edit_users', 'delete_users', 'activate_users', 'deactivate_users', 'assign_roles',
            
            // Role Management
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_roles',
            
            // Permission Management
            'view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions', 'assign_permissions',
            
            // Settings
            'view_settings', 'edit_settings',
            
            // License Management
            'view_licenses', 'create_licenses', 'edit_licenses', 'delete_licenses', 'verify_licenses', 'activate_licenses', 'deactivate_licenses',
            
            // Content Management (for future use)
            'view_content', 'create_content', 'edit_content', 'delete_content', 'publish_content', 'unpublish_content',
            
            // File Management (for future use)
            'view_files', 'upload_files', 'download_files', 'delete_files',
            
            // Reports & Analytics (for future use)
            'view_reports', 'export_data', 'view_analytics',
            
            // System Management (super admin only)
            'manage_system', 'manage_licenses', 'manage_users', 'manage_roles', 'manage_permissions'
        ];

        // Create permissions if they don't exist
        foreach ($allPermissions as $permissionName) {
            if (!Permission::where('name', $permissionName)->exists()) {
                Permission::create([
                    'name' => $permissionName,
                    'display_name' => ucwords(str_replace('_', ' ', $permissionName)),
                    'guard_name' => 'web'
                ]);
            }
        }

        // Get all permissions (including newly created ones)
        $permissions = Permission::all();

        // Create roles if they don't exist
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin'], ['display_name' => 'Super Administrator']);
        $admin = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Administrator']);
        $manager = Role::firstOrCreate(['name' => 'manager'], ['display_name' => 'Manager']);
        $editor = Role::firstOrCreate(['name' => 'editor'], ['display_name' => 'Editor']);
        $user = Role::firstOrCreate(['name' => 'user'], ['display_name' => 'User']);
        $guest = Role::firstOrCreate(['name' => 'guest'], ['display_name' => 'Guest']);

        // Assign permissions to Super Admin (all permissions)
        $superAdmin->givePermissionTo($permissions);

        // Assign permissions to Admin (most permissions except super admin ones)
        $adminPermissions = $permissions->filter(function ($permission) {
            return !str_starts_with($permission->name, 'manage_system') && 
                   !str_starts_with($permission->name, 'delete_roles') &&
                   !str_starts_with($permission->name, 'delete_permissions');
        });
        $admin->givePermissionTo($adminPermissions);

        // Assign permissions to Manager
        $managerPermissions = $permissions->filter(function ($permission) {
            return in_array($permission->name, [
                'view_dashboard',
                'view_users', 'edit_users', 'activate_users', 'deactivate_users',
                'view_licenses', 'verify_licenses',
                'view_settings',
                'view_content', 'create_content', 'edit_content', 'publish_content', 'unpublish_content',
                'view_files', 'upload_files', 'download_files',
                'view_reports', 'export_data',
                'view_analytics',
            ]);
        });
        $manager->givePermissionTo($managerPermissions);

        // Assign permissions to Editor
        $editorPermissions = $permissions->filter(function ($permission) {
            return in_array($permission->name, [
                'view_dashboard',
                'view_content', 'create_content', 'edit_content', 'publish_content', 'unpublish_content',
                'view_files', 'upload_files', 'download_files',
                'view_reports',
            ]);
        });
        $editor->givePermissionTo($editorPermissions);

        // Assign permissions to User
        $userPermissions = $permissions->filter(function ($permission) {
            return in_array($permission->name, [
                'view_dashboard',
                'view_content',
                'view_files', 'download_files',
            ]);
        });
        $user->givePermissionTo($userPermissions);

        // Guest has no permissions by default
        // $guest->givePermissionTo([]);

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Found ' . $permissions->count() . ' existing permissions');
        $this->command->info('Created ' . Role::count() . ' roles');
    }
} 