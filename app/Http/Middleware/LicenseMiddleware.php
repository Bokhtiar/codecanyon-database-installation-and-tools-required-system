<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\LicenseService;
use Symfony\Component\HttpFoundation\Response;

class LicenseMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if system has a valid license
        if (!LicenseService::hasValidLicense()) {
            // Redirect to license activation page
            return redirect()->route('license.activate')->with('error', 'Please activate your license to continue with installation.');
        }

        return $next($request);
    }
} 