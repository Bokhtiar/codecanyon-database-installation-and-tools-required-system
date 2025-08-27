<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Check if user has any admin panel access permissions
            if (!$user->hasPermissionTo('view_dashboard') && !$user->hasPermissionTo('view_users') && !$user->hasPermissionTo('view_roles') && !$user->hasPermissionTo('view_permissions') && !$user->hasPermissionTo('view_settings')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Access denied. Admin panel access required.']);
            }

            $user->update(['last_login_at' => now()]);
            
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
} 