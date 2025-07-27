<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    public function index()
    {
        try {
            Log::info('WelcomeController: Starting to fetch users');
            
            // Fetch users (database config is handled globally)
            $users = User::all();
            Log::info('WelcomeController: Users fetched successfully, count: ' . $users->count());
            
            return view('welcome', compact('users'));
            
        } catch (\Exception $e) {
            Log::error('WelcomeController Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // If database connection fails, redirect to installation
            return redirect('/install');
        }
    }
}
