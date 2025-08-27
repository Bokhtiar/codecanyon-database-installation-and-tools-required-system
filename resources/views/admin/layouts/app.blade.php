<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">
                        Admin Panel
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                    @can('view_dashboard')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                    @endcan
                    
                    @can('view_users')
                    <a href="{{ route('admin.users.index') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-users mr-2"></i> Users
                    </a>
                    @endcan
                    
                    @can('view_roles')
                    <a href="{{ route('admin.roles.index') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.roles.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-user-tag mr-2"></i> Roles
                    </a>
                    @endcan
                    
                    @can('view_permissions')
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-key mr-2"></i> Permissions
                    </a>
                    @endcan
                    
                    @can('view_settings')
                    <a href="{{ route('admin.settings') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.settings*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    @endcan
                    
                    @can('view_licenses')
                    <a href="{{ route('admin.licenses.index') }}" 
                       class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.licenses.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="fas fa-key mr-2"></i> Licenses
                    </a>
                    @endcan
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- License Warnings -->
            @if(session('license_warning'))
                @php
                    $warning = session('license_warning');
                @endphp
                <div class="bg-{{ $warning['type'] }}-100 border border-{{ $warning['type'] }}-400 text-{{ $warning['type'] }}-700 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ $warning['message'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html> 