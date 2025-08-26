<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account Setup - Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-user-shield text-blue-600 mr-3"></i>
                    Admin Account Setup - Step 4
                </h1>
                <p class="text-gray-600">Create your administrator account to manage the application</p>
            </div>

            <!-- Setup Progress -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-sm font-medium text-gray-500">Setup Progress</span>
                    <span class="text-sm font-medium text-blue-600">Step 4 of 5</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                    <span class="text-xs text-gray-500">80%</span>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span>✅ License Activated</span>
                    <span>✅ Requirements Checked</span>
                    <span>✅ Database Config</span>
                    <span>🔄 Admin Setup</span>
                    <span>⏳ Finish</span>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Admin Account Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        <i class="fas fa-user-plus text-blue-600 mr-2"></i>
                        Administrator Account Details
                    </h2>
                    <p class="text-gray-600">This account will have full access to manage your application, users, and settings.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-400 mt-1 mr-3"></i>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="/install/admin" id="adminForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-500 mr-2"></i>
                                Full Name
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="John Doe"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">Your full name as it will appear in the system</p>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-500 mr-2"></i>
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="admin@example.com"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">This will be your login username</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-500 mr-2"></i>
                                Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="••••••••"
                                required
                                minlength="6"
                            >
                            <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-500 mr-2"></i>
                                Confirm Password
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="••••••••"
                                required
                                minlength="6"
                            >
                            <p class="text-xs text-gray-500 mt-1">Must match your password</p>
                        </div>
                    </div>

                    <!-- Security Best Practices -->
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="text-sm font-medium text-yellow-800 mb-2">
                            <i class="fas fa-shield-alt text-yellow-600 mr-2"></i>
                            Security Best Practices
                        </h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• <strong>Strong Password:</strong> Use a combination of letters, numbers, and symbols</li>
                            <li>• <strong>Unique Email:</strong> Don't use this email for other accounts</li>
                            <li>• <strong>Keep Secure:</strong> Never share your admin credentials</li>
                            <li>• <strong>Regular Updates:</strong> Change password periodically</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                        <a href="/install/database" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Previous Step
                        </a>
                        
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>
                            Create Admin & Finish
                        </button>
                    </div>
                </form>
            </div>

            <!-- What Happens Next -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    What Happens Next?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-database text-2xl text-green-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Database Setup</h4>
                        <p class="text-sm text-gray-600">Tables and initial data will be created</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-user-shield text-2xl text-blue-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Admin Account</h4>
                        <p class="text-sm text-gray-600">Your administrator account will be created</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-check-circle text-2xl text-purple-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Installation Complete</h4>
                        <p class="text-sm text-gray-600">You'll be redirected to the finish page</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Creating Admin Account...</h3>
            <p class="text-gray-600">Please wait while we set up your administrator account and complete the installation.</p>
            <p class="text-sm text-gray-500 mt-2">This may take a few moments...</p>
        </div>
    </div>

    <script>
        document.getElementById('adminForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
            
            // Show loading overlay
            loadingOverlay.classList.remove('hidden');
            
            // Form will submit normally
        });
    </script>
</body>
</html>
