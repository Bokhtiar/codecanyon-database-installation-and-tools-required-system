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

        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return redirect('/admin/login')->withErrors(['email' => 'Access denied. Admin privileges required.']);
        }

        return $next($request);
    }
} 