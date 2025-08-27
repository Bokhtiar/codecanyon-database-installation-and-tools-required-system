@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create New Permission</h1>
                <p class="text-gray-600 mt-2">Add a new permission to the system</p>
            </div>
            
            <a href="{{ route('admin.permissions.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Permissions
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                
                <div class="px-4 py-5 sm:p-6 space-y-6">
                    <!-- Permission Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                        <div class="mt-1">
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror"
                                   placeholder="e.g., create_users"
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Use snake_case format (e.g., create_users, edit_posts)</p>
                    </div>

                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700">Display Name</label>
                        <div class="mt-1">
                            <input type="text" 
                                   name="display_name" 
                                   id="display_name" 
                                   value="{{ old('display_name') }}"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('display_name') border-red-300 @enderror"
                                   placeholder="e.g., Create Users"
                                   required>
                        </div>
                        @error('display_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Human-readable name for the permission</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror"
                                      placeholder="Describe what this permission allows users to do">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Optional description of the permission's purpose</p>
                    </div>

                    <!-- Guard Name -->
                    <div>
                        <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard Name</label>
                        <div class="mt-1">
                            <select name="guard_name" 
                                    id="guard_name" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('guard_name') border-red-300 @enderror"
                                    required>
                                <option value="web" {{ old('guard_name', 'web') == 'web' ? 'selected' : '' }}>Web (Default)</option>
                                <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API</option>
                            </select>
                        </div>
                        @error('guard_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Authentication guard for this permission</p>
                    </div>

                    <!-- Permission Examples -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Common Permission Examples</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <strong class="text-gray-700">User Management:</strong>
                                <ul class="text-gray-600 mt-1 space-y-1">
                                    <li>• view_users</li>
                                    <li>• create_users</li>
                                    <li>• edit_users</li>
                                    <li>• delete_users</li>
                                </ul>
                            </div>
                            <div>
                                <strong class="text-gray-700">Content Management:</strong>
                                <ul class="text-gray-600 mt-1 space-y-1">
                                    <li>• view_posts</li>
                                    <li>• create_posts</li>
                                    <li>• edit_posts</li>
                                    <li>• publish_posts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" 
                            onclick="window.history.back()"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 