@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
                    <p class="mt-2 text-gray-600">View user information and permissions</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Users
                    </a>
                    @can('edit_users')
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        Edit User
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Profile</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal information and account details</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center space-x-4">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-2xl font-bold text-gray-700">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h4>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($user->hasRole('admin'))
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('F d, Y \a\t g:i A') : 'Never logged in' }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role and Permissions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Role & Permissions</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Current role assignment and inherited permissions</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($user->roles->first())
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Assigned Role</h4>
                        <div class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $user->roles->first()->name === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                            <i class="fas fa-user-shield mr-2"></i>
                            {{ ucwords(str_replace('_', ' ', $user->roles->first()->name)) }}
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-3">Permissions ({{ $user->roles->first()->permissions->count() }})</h4>
                        @if($user->roles->first()->permissions->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($user->roles->first()->permissions as $permission)
                                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    <span class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No permissions assigned to this role.</p>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-3xl mb-3"></i>
                        <p class="text-gray-500 mb-4">No role assigned to this user.</p>
                        @can('edit_users')
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-user-plus mr-2"></i>
                            Assign Role
                        </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Activity -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Account Activity</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Recent account activities and changes</p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-plus text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-900">Account created</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    @if($user->updated_at != $user->created_at)
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-edit text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-900">Profile updated</p>
                            <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($user->last_login_at)
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-sign-in-alt text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-900">Last login</p>
                            <p class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 