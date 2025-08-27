<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users');
    }

    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $this->middleware('permission:create_users');
        
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $this->middleware('permission:create_users');
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|exists:roles,name',
                'is_active' => 'boolean',
                'send_welcome_email' => 'boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => $request->has('is_active'),
            ]);

            // Assign role
            $user->assignRole($request->role);

            // Send welcome email if requested
            if ($request->has('send_welcome_email')) {
                // TODO: Implement welcome email functionality
                // Mail::to($user)->send(new WelcomeEmail($user, $request->password));
            }

            DB::commit();
            
            // Check if request wants JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully!',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $request->role
                    ]
                ]);
            }
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $this->middleware('permission:view_users');
        
        $user->load('roles', 'permissions');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $this->middleware('permission:edit_users');
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $this->middleware('permission:edit_users');
        
        try {
            $validationRules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|exists:roles,name',
                'is_active' => 'boolean',
                'send_notification' => 'boolean',
            ];

            // Password validation only if provided
            if ($request->filled('password')) {
                $validationRules['password'] = 'required|string|min:8|confirmed';
            }

            $request->validate($validationRules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            DB::beginTransaction();
            
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->has('is_active'),
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            // Update role if changed
            $currentRole = $user->roles->first();
            if (!$currentRole || $currentRole->name !== $request->role) {
                // Remove current role and assign new one
                if ($currentRole) {
                    $user->removeRole($currentRole);
                }
                $user->assignRole($request->role);
            }

            // Send notification if requested
            if ($request->has('send_notification')) {
                // TODO: Implement notification email functionality
                // Mail::to($user)->send(new AccountUpdateNotification($user));
            }

            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $this->middleware('permission:delete_users');
        
        // Prevent deletion of own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Prevent deletion of super admin
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super administrators cannot be deleted!');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        $this->middleware('permission:activate_users');
        
        try {
            $user->update(['is_active' => !$user->is_active]);
            
            $status = $user->is_active ? 'activated' : 'deactivated';
            return back()->with('success', "User {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request, User $user)
    {
        $this->middleware('permission:assign_roles');
        
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user->syncRoles([$request->role]);
            
            return back()->with('success', 'Role assigned successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request, User $user)
    {
        $this->middleware('permission:assign_roles');
        
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user->removeRole($request->role);
            
            return back()->with('success', 'Role removed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove role: ' . $e->getMessage());
        }
    }

    /**
     * Show user permissions
     */
    public function permissions(User $user)
    {
        $this->middleware('permission:view_users');
        
        $user->load('roles.permissions');
        $allPermissions = $user->getAllPermissions();
        
        return view('admin.users.permissions', compact('user', 'allPermissions'));
    }

    /**
     * Bulk actions on users
     */
    public function bulkAction(Request $request)
    {
        $this->middleware('permission:edit_users');
        
        $request->validate([
            'users' => 'required|array',
            'action' => 'required|in:activate,deactivate,delete,assign_role',
            'role' => 'required_if:action,assign_role|exists:roles,name',
        ]);

        try {
            $users = User::whereIn('id', $request->users)->get();
            
            switch ($request->action) {
                case 'activate':
                    $users->each(function ($user) {
                        $user->update(['is_active' => true]);
                    });
                    $message = 'Users activated successfully!';
                    break;
                    
                case 'deactivate':
                    $users->each(function ($user) {
                        $user->update(['is_active' => false]);
                    });
                    $message = 'Users deactivated successfully!';
                    break;
                    
                case 'delete':
                    $users->each(function ($user) {
                        if ($user->id !== auth()->id() && !$user->hasRole('super_admin')) {
                            $user->delete();
                        }
                    });
                    $message = 'Users deleted successfully!';
                    break;
                    
                case 'assign_role':
                    $users->each(function ($user) use ($request) {
                        $user->syncRoles([$request->role]);
                    });
                    $message = 'Role assigned to users successfully!';
                    break;
            }
            
            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to perform bulk action: ' . $e->getMessage());
        }
    }
} 