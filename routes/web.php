<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\LicenseController as AdminLicenseController;
use App\Models\User;

// License routes (ALWAYS accessible - first step)
Route::get('/license/activate', [LicenseController::class, 'showActivation'])->name('license.activate');
Route::post('/license/activate', [LicenseController::class, 'activate'])->name('license.activate.post');
Route::get('/license/status', [LicenseController::class, 'showStatus'])->name('license.status');
Route::post('/license/verify', [LicenseController::class, 'verify'])->name('license.verify');
Route::post('/license/deactivate', [LicenseController::class, 'deactivate'])->name('license.deactivate');

// Demo information page (always accessible)
Route::get('/demo/purchase-info', [App\Http\Controllers\DemoController::class, 'purchaseInfo'])->name('demo.purchase-info');
Route::get('/demo/license-examples', [App\Http\Controllers\DemoController::class, 'licenseExamples'])->name('demo.license-examples');

// Installation routes (always accessible during setup)
Route::get('/install', [InstallController::class, 'welcome'])->name('install.welcome');
Route::get('/install/requirements', [InstallController::class, 'requirements'])->name('install.requirements');
Route::get('/install/env', [InstallController::class, 'envForm'])->name('install.env');
Route::post('/install/env', [InstallController::class, 'saveEnv'])->name('install.saveEnv');
Route::get('/install/database', [InstallController::class, 'dbSetup'])->name('install.database');
Route::post('/install/admin', [InstallController::class, 'createAdmin'])->name('install.admin');
Route::get('/install/finish', [InstallController::class, 'finish'])->name('install.finish');

// All other routes require valid license AND proper installation
Route::group(['middleware' => 'check.install'], function () {
    // Frontend routes
    Route::get('/', [WelcomeController::class, 'index']);
    
    // Admin routes
    Route::group(['prefix' => 'admin'], function () {
        // Guest admin routes
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
        
        // Protected admin routes
        Route::group(['middleware' => ['auth', 'admin']], function () {
            Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
            Route::post('settings', [AdminDashboardController::class, 'updateSettings'])->name('admin.settings.update');
            Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
            
            // User management
            Route::resource('users', AdminUserController::class, ['as' => 'admin']);
            Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
            Route::post('users/{user}/assign-role', [AdminUserController::class, 'assignRole'])->name('admin.users.assign-role');
            Route::post('users/{user}/remove-role', [AdminUserController::class, 'removeRole'])->name('admin.users.remove-role');
            Route::get('users/{user}/permissions', [AdminUserController::class, 'permissions'])->name('admin.users.permissions');
            Route::post('users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('admin.users.bulk-action');
            
            // Role management
            Route::resource('roles', AdminRoleController::class, ['as' => 'admin']);
            Route::post('roles/{role}/assign-role', [AdminRoleController::class, 'assignRole'])->name('admin.roles.assign-role');
            Route::post('roles/{role}/remove-role', [AdminRoleController::class, 'removeRole'])->name('admin.roles.remove-role');
            Route::get('roles/{role}/permissions', [AdminRoleController::class, 'getPermissions'])->name('admin.roles.permissions');
            
            // Permission management
            Route::resource('permissions', AdminPermissionController::class, ['as' => 'admin']);
            Route::get('permissions/category/{category}', [AdminPermissionController::class, 'byCategory'])->name('admin.permissions.by-category');
            Route::post('permissions/bulk-assign', [AdminPermissionController::class, 'bulkAssign'])->name('admin.permissions.bulk-assign');
            Route::post('permissions/bulk-remove', [AdminPermissionController::class, 'bulkRemove'])->name('admin.permissions.bulk-remove');
            
            // License management
            Route::resource('licenses', AdminLicenseController::class, ['as' => 'admin']);
            Route::post('licenses/{license}/verify', [AdminLicenseController::class, 'verify'])->name('admin.licenses.verify');
            Route::post('licenses/{license}/activate', [AdminLicenseController::class, 'activate'])->name('admin.licenses.activate');
            Route::post('licenses/{license}/deactivate', [AdminLicenseController::class, 'deactivate'])->name('admin.licenses.deactivate');
            Route::post('licenses/bulk-verify', [AdminLicenseController::class, 'bulkVerify'])->name('admin.licenses.bulk-verify');
        });
    });
});

