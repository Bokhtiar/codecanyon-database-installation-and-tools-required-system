<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global database configuration for different environments
        try {
            // Check if we're running inside Docker container
            if (file_exists('/.dockerenv')) {
                // Docker environment - use Docker service name
                config(['database.connections.mysql.host' => 'db']);
                config(['database.connections.mysql.port' => 3306]);
                Log::info('AppServiceProvider: Docker environment detected - using host=db, port=3306');
            } else {
                // Non-Docker environment - check .env file
                $dbHost = env('DB_HOST', '127.0.0.1');
                $dbPort = env('DB_PORT', 3306);
                
                // If .env has Docker hostname but we're not in Docker, use localhost
                if ($dbHost === 'db') {
                    config(['database.connections.mysql.host' => '127.0.0.1']);
                    config(['database.connections.mysql.port' => 3308]); // Docker mapped port
                    Log::info('AppServiceProvider: Non-Docker environment with Docker config - using host=127.0.0.1, port=3308');
                } else {
                    // Use .env configuration as is
                    config(['database.connections.mysql.host' => $dbHost]);
                    config(['database.connections.mysql.port' => $dbPort]);
                    Log::info("AppServiceProvider: Non-Docker environment - using host={$dbHost}, port={$dbPort}");
                }
            }
        } catch (\Exception $e) {
            Log::warning('AppServiceProvider: Could not apply database config: ' . $e->getMessage());
        }
    }
}
