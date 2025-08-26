<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'active_users' => User::where('is_active', true)->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_users'));
    }

    public function settings()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_description' => 'nullable|string',
        ]);

        Setting::set('site_name', $request->site_name, 'string', 'general', 'Site Name');
        Setting::set('site_email', $request->site_email, 'string', 'general', 'Site Email');
        Setting::set('site_description', $request->site_description, 'text', 'general', 'Site Description');

        return back()->with('success', 'Settings updated successfully!');
    }
} 