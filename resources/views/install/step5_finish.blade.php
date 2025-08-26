<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Complete - {{ config('app.name', 'Laravel') }}</title>
    
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
                    Installation Complete!
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Your application is now ready to use
                </p>
            </div>

            <!-- Setup Flow Steps -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Setup Progress</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">License Activation</p>
                            <p class="text-xs text-green-600">Completed</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">System Installation</p>
                            <p class="text-xs text-green-600">Completed</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">Ready to Use</p>
                            <p class="text-xs text-green-600">All set!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div class="bg-green-50 border border-green-200 rounded-md p-6">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-green-800 mb-4">🎉 Congratulations!</h3>
                    <p class="text-green-700 mb-6">
                        Your {{ config('app.name', 'Laravel') }} application has been successfully installed and configured. 
                        You can now start using all the features.
                    </p>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">What's Next?</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fas fa-tachometer-alt text-blue-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Access Admin Panel</p>
                            <p class="text-xs text-gray-500">Manage your application, users, and settings</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fas fa-home text-blue-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Visit Frontend</p>
                            <p class="text-xs text-gray-500">See your application in action</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fas fa-cog text-blue-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Configure Settings</p>
                            <p class="text-xs text-gray-500">Customize your application settings</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4 justify-center">
                <a href="{{ route('admin.login') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Go to Admin Panel
                </a>
                
                <a href="/" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-home mr-2"></i>
                    Visit Frontend
                </a>
            </div>

            <!-- Additional Links -->
            <div class="text-center space-y-2">
                <a href="{{ route('license.status') }}" class="text-sm text-blue-600 hover:text-blue-500 block">
                    <i class="fas fa-key mr-1"></i>
                    View License Status
                </a>
                <a href="{{ route('admin.settings') }}" class="text-sm text-blue-600 hover:text-blue-500 block">
                    <i class="fas fa-cog mr-1"></i>
                    Configure Settings
                </a>
            </div>

            <!-- Support Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="text-center">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Need Help?</h4>
                    <p class="text-xs text-blue-700">
                        Check the documentation or contact support if you need assistance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
