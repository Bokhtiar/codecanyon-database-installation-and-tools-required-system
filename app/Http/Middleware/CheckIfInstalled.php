<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\LicenseService;
use Symfony\Component\HttpFoundation\Response;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip license and installation checks for license routes
        if ($request->is('license*')) {
            return $next($request);
        }

        // First: Check if system has a valid license
        if (!LicenseService::hasValidLicense()) {
            return redirect()->route('license.activate')->with('error', 'Please activate your license to continue.');
        }

        // Second: Check if APP_INSTALLED is set to true
        if (env('APP_INSTALLED') !== 'true' && env('APP_INSTALLED') !== true && env('APP_INSTALLED') !== '1') {
            return redirect('/install');
        }

        // Third: Check if database is properly configured and accessible
        try {
            // Test database connection
            DB::connection()->getPdo();
            
            // Check if essential tables exist
            if (!Schema::hasTable('users')) {
                // Users table doesn't exist, redirect to installation
                return redirect('/install');
            }
            
            // Check if roles table exists (Spatie)
            if (!Schema::hasTable('roles')) {
                // Roles table doesn't exist, redirect to installation
                return redirect('/install');
            }
            
            // Check if at least one admin user exists with admin role
            try {
                $adminUser = \App\Models\User::role('admin')->first();
                if (!$adminUser) {
                    // No admin user with admin role found, redirect to installation
                    return redirect('/install');
                }
            } catch (\Exception $e) {
                // If Spatie is not working, fallback to basic check
                $adminUser = DB::table('users')->first();
                if (!$adminUser) {
                    // No users found, redirect to installation
                    return redirect('/install');
                }
            }
            
        } catch (\Exception $e) {
            // Database connection failed, redirect to installation
            return redirect('/install');
        }
        
        return $next($request);
    }
}
