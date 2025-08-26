<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Status - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    License Status
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Your license information and status
                </p>
            </div>
            
            <!-- License Information Card -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">License Details</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- License Key -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">License Key:</span>
                        <span class="text-sm text-gray-900 font-mono">{{ $license->license_key }}</span>
                    </div>
                    
                    <!-- Status -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $license->getStatusBadge() }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </div>
                    
                    <!-- Domain -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Domain:</span>
                        <span class="text-sm text-gray-900">{{ $license->domain }}</span>
                    </div>
                    
                    <!-- License Type -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">License Type:</span>
                        <span class="text-sm text-gray-900">{{ ucfirst($license->license_type) }}</span>
                    </div>
                    
                    <!-- Expires At -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Expires At:</span>
                        <span class="text-sm text-gray-900">
                            @if($license->expires_at)
                                {{ $license->expires_at->format('M d, Y') }}
                                @if($license->needsRenewal())
                                    <span class="ml-2 text-red-600 font-medium">(Expires soon!)</span>
                                @endif
                            @else
                                <span class="text-green-600">Never (Lifetime)</span>
                            @endif
                        </span>
                    </div>
                    
                    <!-- Support Until -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Support Until:</span>
                        <span class="text-sm text-gray-900">
                            @if($license->support_until)
                                {{ $license->support_until->format('M d, Y') }}
                            @else
                                <span class="text-green-600">Lifetime Support</span>
                            @endif
                        </span>
                    </div>
                    
                    <!-- Item Name -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Item Name:</span>
                        <span class="text-sm text-gray-900">{{ $license->item_name }}</span>
                    </div>
                    
                    <!-- Buyer Email -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Buyer Email:</span>
                        <span class="text-sm text-gray-900">{{ $license->buyer_email }}</span>
                    </div>
                    
                    <!-- Last Verified -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Last Verified:</span>
                        <span class="text-sm text-gray-900">
                            {{ $license->verified_at ? $license->verified_at->format('M d, Y H:i') : 'Never' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex space-x-4 justify-center">
                <form method="POST" action="{{ route('license.verify') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-sync-alt mr-2"></i>Verify License
                    </button>
                </form>
                
                <form method="POST" action="{{ route('license.deactivate') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="return confirm('Are you sure you want to deactivate your license?')">
                        <i class="fas fa-lock mr-2"></i>Deactivate
                    </button>
                </form>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                </a>
            </div>
            
            <!-- Warning Messages -->
            @if($license->needsRenewal())
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">License Expiring Soon</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Your license will expire in {{ $license->getDaysUntilExpiry() }} days. Please renew to continue using the application.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($license->status !== 'active')
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">License Inactive</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Your license is currently inactive. Please contact support or reactivate your license.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html> 