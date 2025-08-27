<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        $user = Auth::user();
        
        // Check if user has any admin panel access permissions
        if (!$user->hasPermissionTo('view_dashboard') && !$user->hasPermissionTo('view_users') && !$user->hasPermissionTo('view_roles') && !$user->hasPermissionTo('view_permissions') && !$user->hasPermissionTo('view_settings')) {
            Auth::logout();
            return redirect('/admin/login')->withErrors(['email' => 'Access denied. Admin panel access required.']);
        }

        return $next($request);
    }
} 