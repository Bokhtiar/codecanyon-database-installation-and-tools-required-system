<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Configuration - Installation Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-database text-blue-600 mr-3"></i>
                    Database Configuration - Step 3
                </h1>
                <p class="text-gray-600">Configure your database connection settings</p>
            </div>

            <!-- Setup Progress -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-sm font-medium text-gray-500">Setup Progress</span>
                    <span class="text-sm font-medium text-blue-600">Step 3 of 5</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                    <span class="text-xs text-gray-500">60%</span>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span>✅ License Activated</span>
                    <span>✅ Requirements Checked</span>
                    <span>🔄 Database Config</span>
                    <span>⏳ Admin Setup</span>
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

            <!-- Database Configuration Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">
                        <i class="fas fa-cog text-blue-600 mr-2"></i>
                        Database Connection Settings
                    </h2>
                    <p class="text-gray-600">Enter your database configuration details. The system will create the database and user automatically.</p>
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

                <form action="/install/env" method="POST" id="dbForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Database Host -->
                        <div>
                            <label for="db_host" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-server text-gray-500 mr-2"></i>
                                Database Host
                            </label>
                            <input 
                                type="text" 
                                id="db_host" 
                                name="db_host" 
                                value="{{ old('db_host', $defaultConfig['db_host'] ?? '127.0.0.1') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="127.0.0.1"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">Usually 127.0.0.1 for local development</p>
                        </div>

                        <!-- Database Port -->
                        <div>
                            <label for="db_port" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-plug text-gray-500 mr-2"></i>
                                Database Port
                            </label>
                            <input 
                                type="text" 
                                id="db_port" 
                                value="3308" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500"
                                readonly
                            >
                            <p class="text-xs text-gray-500 mt-1">Docker mapped port (read-only)</p>
                        </div>

                        <!-- Database Name -->
                        <div>
                            <label for="db_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-database text-gray-500 mr-2"></i>
                                Database Name
                            </label>
                            <input 
                                type="text" 
                                id="db_name" 
                                name="db_name" 
                                value="{{ old('db_name', $defaultConfig['db_name'] ?? 'cms') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="cms"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">Will be created automatically if it doesn't exist</p>
                        </div>

                        <!-- Database User -->
                        <div>
                            <label for="db_user" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-500 mr-2"></i>
                                Database Username
                            </label>
                            <input 
                                type="text" 
                                id="db_user" 
                                name="db_user" 
                                value="{{ old('db_user', $defaultConfig['db_user'] ?? 'cm_user') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="cm_user"
                                required
                            >
                            <p class="text-xs text-gray-500 mt-1">Will be created automatically with full privileges</p>
                        </div>

                        <!-- Database Password -->
                        <div class="md:col-span-2">
                            <label for="db_pass" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-500 mr-2"></i>
                                Database Password
                            </label>
                            <input 
                                type="password" 
                                id="db_pass" 
                                name="db_pass" 
                                value="{{ old('db_pass', $defaultConfig['db_pass'] ?? 'cms_secret') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="cms_secret"
                            >
                            <p class="text-xs text-gray-500 mt-1">Leave empty if no password is required</p>
                        </div>
                    </div>

                    <!-- Configuration Tips -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">
                            <i class="fas fa-lightbulb text-blue-600 mr-2"></i>
                            Configuration Tips
                        </h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• <strong>Docker Users:</strong> Use 'db' as host if running inside container, '127.0.0.1' if running on host</li>
                            <li>• <strong>Local Development:</strong> Use '127.0.0.1' or 'localhost' as host</li>
                            <li>• <strong>Port:</strong> Default is 3308 for Docker, 3306 for local MySQL</li>
                            <li>• <strong>Database & User:</strong> Will be created automatically with proper privileges</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                        <a href="/install/requirements" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Previous Step
                        </a>
                        
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Save & Continue
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
                        <i class="fas fa-database text-2xl text-blue-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Database Creation</h4>
                        <p class="text-sm text-gray-600">System will create the database and user automatically</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-table text-2xl text-green-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Table Setup</h4>
                        <p class="text-sm text-gray-600">Laravel migrations will create all necessary tables</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-user-shield text-2xl text-purple-600 mb-2"></i>
                        <h4 class="font-medium text-gray-900">Admin Account</h4>
                        <p class="text-sm text-gray-600">Next step: Create your admin user account</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Setting Up Database...</h3>
            <p class="text-gray-600">Please wait while we create your database and configure the connection.</p>
            <p class="text-sm text-gray-500 mt-2">This may take a few moments...</p>
        </div>
    </div>

    <script>
        document.getElementById('dbForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Setting Up...';
            
            // Show loading overlay
            loadingOverlay.classList.remove('hidden');
            
            // Form will submit normally
        });
    </script>
</body>
</html>
