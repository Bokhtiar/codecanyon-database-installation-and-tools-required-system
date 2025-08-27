<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_roles');
    }

    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $this->middleware('permission:create_roles');
        
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0];
        });
        
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $this->middleware('permission:create_roles');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            DB::commit();
            
            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        $this->middleware('permission:edit_roles');
        
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0];
        });
        
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        $this->middleware('permission:edit_roles');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
        ]);

        try {
            DB::beginTransaction();
            
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            DB::commit();
            
            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        $this->middleware('permission:delete_roles');
        
        // Prevent deletion of system roles
        if (in_array($role->name, ['super_admin', 'admin', 'user'])) {
            return back()->with('error', 'System roles cannot be deleted!');
        }

        try {
            $role->delete();
            return redirect()->route('admin.roles.index')
                ->with('success', 'Role deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    /**
     * Show role details
     */
    public function show(Role $role)
    {
        $this->middleware('permission:view_roles');
        
        $users = $role->users()->paginate(10);
        $permissions = $role->permissions;
        
        return view('admin.roles.show', compact('role', 'users', 'permissions'));
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $this->middleware('permission:assign_roles');
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $user = \App\Models\User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);
            
            $user->assignRole($role);
            
            return back()->with('success', "Role '{$role->display_name}' assigned to user successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        $this->middleware('permission:assign_roles');
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $user = \App\Models\User::findOrFail($request->user_id);
            $role = Role::findOrFail($request->role_id);
            
            $user->removeRole($role);
            
            return back()->with('success', "Role '{$role->display_name}' removed from user successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove role: ' . $e->getMessage());
        }
    }

    /**
     * Get permissions for a specific role
     */
    public function getPermissions(Role $role)
    {
        $this->middleware('permission:view_roles');
        
        try {
            $permissions = $role->permissions->pluck('id')->toArray();
            
            return response()->json([
                'success' => true,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get role permissions: ' . $e->getMessage()
            ], 500);
        }
    }
} 