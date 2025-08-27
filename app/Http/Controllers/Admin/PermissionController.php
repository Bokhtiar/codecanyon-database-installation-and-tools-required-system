<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_permissions');
    }

    /**
     * Display a listing of permissions
     */
    public function index()
    {
        $permissions = Permission::with('roles')->paginate(20);
        
        // Group permissions by category
        $allPermissions = Permission::all();
        $groupedPermissions = $allPermissions->groupBy(function ($permission) {
            return explode('_', $permission->name)[0];
        });
        
        return view('admin.permissions.index', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        $this->middleware('permission:create_permissions');
        
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $this->middleware('permission:create_permissions');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|max:255',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'guard_name' => $request->guard_name,
            ]);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission created successfully!');
                
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create permission: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified permission
     */
    public function edit(Permission $permission)
    {
        $this->middleware('permission:edit_permissions');
        
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        $this->middleware('permission:edit_permissions');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'guard_name' => 'required|string|max:255',
        ]);

        try {
            $permission->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'guard_name' => $request->guard_name,
            ]);

            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission updated successfully!');
                
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update permission: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission)
    {
        $this->middleware('permission:delete_permissions');
        
        // Prevent deletion of system permissions
        if (in_array($permission->name, ['view_dashboard', 'view_users'])) {
            return back()->with('error', 'System permissions cannot be deleted!');
        }

        try {
            $permission->delete();
            return redirect()->route('admin.permissions.index')
                ->with('success', 'Permission deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }

    /**
     * Show permission details
     */
    public function show(Permission $permission)
    {
        $this->middleware('permission:view_permissions');
        
        $roles = $permission->roles;
        $users = $permission->users;
        
        return view('admin.permissions.show', compact('permission', 'roles', 'users'));
    }

    /**
     * Show permissions by category
     */
    public function byCategory($category)
    {
        $this->middleware('permission:view_permissions');
        
        $permissions = Permission::where('name', 'like', $category . '_%')
            ->with('roles')
            ->get();
            
        $roles = Role::all();
        
        return view('admin.permissions.by-category', compact('permissions', 'roles', 'category'));
    }

    /**
     * Bulk assign permissions to roles
     */
    public function bulkAssign(Request $request)
    {
        $this->middleware('permission:assign_permissions');
        
        $request->validate([
            'permissions' => 'required|array',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $role = Role::findOrFail($request->role_id);
            
            // Critical permissions that admin role must always have
            $criticalPermissions = [
                'view_dashboard',      // Must be able to see dashboard
                'view_users',          // Must be able to see users
                'view_roles',          // Must be able to see roles
                'view_permissions',    // Must be able to see permissions
                'view_settings',       // Must be able to see settings
                'assign_permissions',  // Must be able to assign permissions
                'assign_roles'        // Must be able to assign roles
            ];
            
            // If this is the admin role, ensure critical permissions are included
            if ($role->name === 'admin') {
                $requestedPermissions = $request->permissions;
                
                // Check if any critical permissions are missing
                $missingCritical = array_diff($criticalPermissions, $requestedPermissions);
                
                if (!empty($missingCritical)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Admin role must have these critical permissions: ' . implode(', ', $missingCritical)
                    ], 400);
                }
            }
            
            // Sync permissions (this will remove old ones and add new ones)
            $role->syncPermissions($request->permissions);
            
            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk remove permissions from roles
     */
    public function bulkRemove(Request $request)
    {
        $this->middleware('permission:assign_permissions');
        
        $request->validate([
            'permissions' => 'required|array',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $role = Role::findOrFail($request->role_id);
            $role->revokePermissionTo($request->permissions);
            
            return back()->with('success', 'Permissions removed from role successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove permissions: ' . $e->getMessage());
        }
    }
} 