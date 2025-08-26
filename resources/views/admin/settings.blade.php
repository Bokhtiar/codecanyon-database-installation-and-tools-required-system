@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
        <p class="text-gray-600">Manage your site configuration</p>
    </div>

    <!-- Settings Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                    <input type="text" name="site_name" id="site_name" 
                           value="{{ old('site_name', $settings['general']['site_name']['value'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           required>
                    <p class="mt-1 text-sm text-gray-500">The name of your website</p>
                </div>

                <div>
                    <label for="site_email" class="block text-sm font-medium text-gray-700">Site Email</label>
                    <input type="email" name="site_email" id="site_email" 
                           value="{{ old('site_email', $settings['general']['site_email']['value'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Contact email for your website</p>
                </div>

                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700">Site Description</label>
                    <textarea name="site_description" id="site_description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('site_description', $settings['general']['site_description']['value'] ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Brief description of your website</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <!-- License Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">License Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">License Status</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Domain</h4>
                    <p class="mt-1 text-sm text-gray-900">{{ request()->getHost() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 