@extends('admin.layouts.app')

@section('title', 'Permissions Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Permissions Management</h1>
            <p class="text-gray-600 mt-2">Manage system permissions and access control</p>
        </div>
        
        @can('create_permissions')
        <a href="{{ route('admin.permissions.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i>
            Create Permission
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-key text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Permissions</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $permissions->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">User Permissions</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $permissions->where('name', 'like', 'user_%')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Admin Permissions</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $permissions->where('name', 'like', 'admin_%')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-cog text-orange-600 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">System Permissions</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $permissions->where('name', 'like', 'manage_%')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">All Permissions</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete list of system permissions with their details</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permission</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guard</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-key text-blue-600 text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 font-mono">{{ $permission->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $permission->display_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $permission->description ?? 'No description available' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $permission->guard_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @forelse($permission->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $role->display_name ?? $role->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-xs">No roles assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @can('view_permissions')
                                <a href="{{ route('admin.permissions.show', $permission) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endcan
                                
                                @can('edit_permissions')
                                <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                   class="text-indigo-600 hover:text-indigo-900" title="Edit Permission">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                
                                @can('delete_permissions')
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            title="Delete Permission"
                                            onclick="return confirm('Are you sure you want to delete this permission?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-key text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-900 mb-2">No permissions found</p>
                                <p class="text-gray-500">Get started by creating your first permission.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($permissions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>

    <!-- Quick User Creation -->
    @can('create_users')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Quick User Creation</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Create new users and assign roles quickly</p>
                </div>
                
                <button id="showUserFormBtn" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-user-plus mr-2"></i>
                    Create User
                </button>
            </div>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <!-- User Creation Form (Hidden by default) -->
            <div id="userCreationForm" class="hidden">
                <form id="createUserForm" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="user_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" 
                                   id="user_name" 
                                   name="name" 
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   placeholder="Enter full name">
                        </div>
                        
                        <div>
                            <label for="user_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" 
                                   id="user_email" 
                                   name="email" 
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   placeholder="Enter email address">
                        </div>
                        
                        <div>
                            <label for="user_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" 
                                   id="user_password" 
                                   name="password" 
                                   required
                                   minlength="8"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   placeholder="Enter password (min 8 characters)">
                        </div>
                        
                        <div>
                            <label for="user_role" class="block text-sm font-medium text-gray-700">Assign Role</label>
                            <select id="user_role" 
                                    name="role" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Select a role</option>
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}">{{ $role->display_name ?? $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="user_is_active" 
                               name="is_active" 
                               checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="user_is_active" class="ml-2 block text-sm text-gray-900">
                            User is active (can login immediately)
                        </label>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                id="cancelUserBtn"
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" 
                                id="submitUserBtn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Success/Error Messages -->
            <div id="userMessage" class="hidden mt-4"></div>
        </div>
    </div>
    @endcan

    <!-- Quick Role Assignment -->
    @can('assign_roles')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Role Assignment</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Assign a role to get all its permissions automatically</p>
                </div>
            </div>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="quickRoleSelect" class="block text-sm font-medium text-gray-700">Select Role <span class="text-red-500">*</span></label>
                    <select id="quickRoleSelect" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Choose a role</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                            <option value="{{ $role->name }}" data-permissions="{{ $role->permissions->pluck('name')->implode(',') }}">
                                {{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="targetRoleSelect" class="block text-sm font-medium text-gray-700">Assign to Role <span class="text-red-500">*</span></label>
                    <select id="targetRoleSelect" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Choose target role</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                            <option value="{{ $role->name }}">
                                {{ $role->display_name ?? ucwords(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button id="assignRolePermissionsBtn" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-copy mr-2"></i>
                        Copy Permissions
                    </button>
                </div>
            </div>
            
            <div id="roleAssignmentMessage" class="hidden mt-4"></div>
        </div>
    </div>
    @endcan

    <!-- Role Permission Assignment -->
    @can('assign_permissions')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Role Permission Assignment</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Assign permissions to roles using checkboxes</p>
                    <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800">
                                    <strong>Important:</strong> Admin role must always have critical permissions (view_dashboard, view_users, view_roles, view_permissions, view_settings, assign_permissions, assign_roles) to prevent being locked out of the system.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <select id="roleSelect" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Role</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name ?? $role->name }}</option>
                        @endforeach
                    </select>
                    <button id="saveBtn" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
        
        <div class="px-4 py-5 sm:p-6">
            <div class="space-y-6">
                <!-- User Permissions -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-users mr-3 text-blue-600"></i>
                        User Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_users', 'create_users', 'edit_users', 'delete_users', 'activate_users', 'deactivate_users', 'manage_users']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer flex items-center">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                @if(in_array($permission->name, ['view_users']))
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800" title="Critical permission for admin role">
                                        <i class="fas fa-shield-alt mr-1"></i>Critical
                                    </span>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Role Permissions -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-tag mr-3 text-green-600"></i>
                        Role Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_roles', 'manage_roles']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Permission Management -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-key mr-3 text-purple-600"></i>
                        Permission Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_permissions', 'create_permissions', 'edit_permissions', 'delete_permissions', 'assign_permissions', 'manage_permissions']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer flex items-center">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                @if(in_array($permission->name, ['view_permissions', 'assign_permissions']))
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800" title="Critical permission for admin role">
                                        <i class="fas fa-shield-alt mr-1"></i>Critical
                                    </span>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Settings -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cog mr-3 text-orange-600"></i>
                        Settings
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_settings', 'edit_settings']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- License -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-key mr-3 text-red-600"></i>
                        License Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_licenses', 'create_licenses', 'edit_licenses', 'delete_licenses', 'verify_licenses', 'activate_licenses', 'deactivate_licenses', 'manage_licenses']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Dashboard -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-tachometer-alt mr-3 text-indigo-600"></i>
                        Dashboard Access
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_dashboard']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Content Management -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-teal-600"></i>
                        Content Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_content', 'create_content', 'edit_content', 'delete_content', 'publish_content', 'unpublish_content']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- File Management -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-folder mr-3 text-yellow-600"></i>
                        File Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_files', 'upload_files', 'download_files', 'delete_files']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- System Management -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-server mr-3 text-gray-600"></i>
                        System Management
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions->whereIn('name', ['view_reports', 'export_data', 'view_analytics', 'manage_system']) as $permission)
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   id="perm_{{ $permission->id }}" 
                                   class="permission-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   data-permission-id="{{ $permission->id }}"
                                   data-permission-name="{{ $permission->name }}">
                            <label for="perm_{{ $permission->id }}" class="text-sm text-gray-700 cursor-pointer">
                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const saveBtn = document.getElementById('saveBtn');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
    
    // User creation elements
    const showUserFormBtn = document.getElementById('showUserFormBtn');
    const userCreationForm = document.getElementById('userCreationForm');
    const createUserForm = document.getElementById('createUserForm');
    const cancelUserBtn = document.getElementById('cancelUserBtn');
    const userMessage = document.getElementById('userMessage');
    
    // Quick role assignment elements
    const quickRoleSelect = document.getElementById('quickRoleSelect');
    const targetRoleSelect = document.getElementById('targetRoleSelect');
    const assignRolePermissionsBtn = document.getElementById('assignRolePermissionsBtn');
    const roleAssignmentMessage = document.getElementById('roleAssignmentMessage');
    
    if (!roleSelect || !saveBtn) return;
    
    // User creation form toggle
    if (showUserFormBtn) {
        showUserFormBtn.addEventListener('click', function() {
            userCreationForm.classList.toggle('hidden');
            if (!userCreationForm.classList.contains('hidden')) {
                showUserFormBtn.innerHTML = '<i class="fas fa-eye-slash mr-2"></i>Hide Form';
                showUserFormBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                showUserFormBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
            } else {
                showUserFormBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Create User';
                showUserFormBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                showUserFormBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                hideUserMessage();
            }
        });
    }
    
    // Cancel user creation
    if (cancelUserBtn) {
        cancelUserBtn.addEventListener('click', function() {
            userCreationForm.classList.add('hidden');
            showUserFormBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Create User';
            showUserFormBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
            showUserFormBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            createUserForm.reset();
            hideUserMessage();
        });
    }
    
    // User creation form submission
    if (createUserForm) {
        createUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitUserBtn');
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
            
            // Create user via AJAX
            fetch('/admin/users', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Failed to create user');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showUserMessage('User created successfully!', 'success');
                    createUserForm.reset();
                    // Hide form after success
                    setTimeout(() => {
                        userCreationForm.classList.add('hidden');
                        showUserFormBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Create User';
                        showUserFormBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                        showUserFormBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    }, 2000);
                } else {
                    showUserMessage('Failed to create user: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error creating user:', error);
                showUserMessage('Error creating user: ' + error.message, 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Create User';
            });
        });
    }
    
    // Show user message
    function showUserMessage(message, type = 'info') {
        userMessage.className = `mt-4 p-4 rounded-md ${
            type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 
            type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : 
            'bg-blue-50 border border-blue-200 text-blue-800'
        }`;
        userMessage.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas ${type === 'success' ? 'fa-check-circle text-green-400' : 
                                   type === 'error' ? 'fa-exclamation-circle text-red-400' : 
                                   'fa-info-circle text-blue-400'}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
            </div>
        `;
        userMessage.classList.remove('hidden');
    }
    
    // Hide user message
    function hideUserMessage() {
        userMessage.classList.add('hidden');
    }
    
    // Role select change
    roleSelect.addEventListener('change', function() {
        if (this.value) {
            loadRolePermissions(this.value);
            saveBtn.disabled = false;
        } else {
            saveBtn.disabled = true;
            // Uncheck all permissions
            permissionCheckboxes.forEach(cb => cb.checked = false);
        }
    });
    
    // Save button click
    saveBtn.addEventListener('click', function() {
        if (!roleSelect.value) {
            alert('Please select a role first');
            return;
        }
        
        const selectedPermissions = Array.from(permissionCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.dataset.permissionId);
        
        saveRolePermissions(roleSelect.value, selectedPermissions);
    });
    
    // Load permissions for a role
    function loadRolePermissions(roleId) {
        fetch(`/admin/roles/${roleId}/permissions`)
            .then(response => response.json())
            .then(data => {
                // Uncheck all first
                permissionCheckboxes.forEach(cb => cb.checked = false);
                
                // Check permissions the role has
                data.permissions.forEach(permissionId => {
                    const checkbox = document.querySelector(`[data-permission-id="${permissionId}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            })
            .catch(error => {
                console.error('Error loading role permissions:', error);
                alert('Error loading role permissions');
            });
    }
    
    // Save permissions for a role
    function saveRolePermissions(roleId, permissionIds) {
        console.log('Saving permissions for role:', roleId);
        console.log('Selected permission IDs:', permissionIds);
        
        // Get permission names from the checkboxes
        const selectedPermissions = Array.from(permissionCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.dataset.permissionName);
        
        console.log('Selected permission names:', selectedPermissions);
        
        const formData = new FormData();
        formData.append('role_id', roleId);
        selectedPermissions.forEach(name => formData.append('permissions[]', name));
        
        // Show loading state
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        
        fetch('/admin/permissions/bulk-assign', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Permissions updated successfully!');
                location.reload();
            } else {
                alert('Failed to update permissions: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving permissions:', error);
            alert('Error saving permissions: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Changes';
        });
    }

    // Quick role assignment functionality
    if (quickRoleSelect && targetRoleSelect && assignRolePermissionsBtn) {
        // Enable/disable assign button based on selections
        function updateAssignButtonState() {
            const sourceRole = quickRoleSelect.value;
            const targetRole = targetRoleSelect.value;
            const isValid = sourceRole && targetRole && sourceRole !== targetRole;
            
            assignRolePermissionsBtn.disabled = !isValid;
            if (isValid) {
                assignRolePermissionsBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                assignRolePermissionsBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        
        // Update button state when selections change
        quickRoleSelect.addEventListener('change', updateAssignButtonState);
        targetRoleSelect.addEventListener('change', updateAssignButtonState);
        
        // Handle role permission assignment
        assignRolePermissionsBtn.addEventListener('click', function() {
            const sourceRole = quickRoleSelect.value;
            const targetRole = targetRoleSelect.value;
            
            if (!sourceRole || !targetRole || sourceRole === targetRole) {
                showRoleMessage('Please select different source and target roles', 'error');
                return;
            }
            
            // Get permissions from source role
            const sourceOption = quickRoleSelect.querySelector(`option[value="${sourceRole}"]`);
            const permissions = sourceOption.getAttribute('data-permissions');
            
            if (!permissions) {
                showRoleMessage('Source role has no permissions to copy', 'error');
                return;
            }
            
            // Show loading state
            assignRolePermissionsBtn.disabled = true;
            assignRolePermissionsBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Copying...';
            
            // Copy permissions via AJAX
            fetch('/admin/permissions/bulk-assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    role: targetRole,
                    permissions: permissions.split(',').filter(p => p.trim())
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showRoleMessage(`Successfully copied ${permissions.split(',').length} permissions from ${sourceRole} to ${targetRole}`, 'success');
                    
                    // Reset selections
                    quickRoleSelect.value = '';
                    targetRoleSelect.value = '';
                    updateAssignButtonState();
                    
                    // Refresh the role permission assignment section if target role is selected there
                    if (roleSelect.value === targetRole) {
                        loadRolePermissions();
                    }
                } else {
                    showRoleMessage('Failed to copy permissions: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error copying permissions:', error);
                showRoleMessage('Error copying permissions: ' + error.message, 'error');
            })
            .finally(() => {
                // Reset button state
                assignRolePermissionsBtn.disabled = false;
                assignRolePermissionsBtn.innerHTML = '<i class="fas fa-copy mr-2"></i>Copy Permissions';
            });
        });
        
        // Initialize button state
        updateAssignButtonState();
    }
    
    // Show role assignment message
    function showRoleMessage(message, type = 'info') {
        roleAssignmentMessage.className = `mt-4 p-4 rounded-md ${
            type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 
            type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : 
            'bg-blue-50 border border-blue-200 text-blue-800'
        }`;
        roleAssignmentMessage.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas ${type === 'success' ? 'fa-check-circle text-green-400' : 
                                   type === 'error' ? 'fa-exclamation-circle text-red-400' : 
                                   'fa-info-circle text-blue-400'}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
            </div>
        `;
        roleAssignmentMessage.classList.remove('hidden');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            roleAssignmentMessage.classList.add('hidden');
        }, 5000);
    }
});
</script>
@endpush
@endsection