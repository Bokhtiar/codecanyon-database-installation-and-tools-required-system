<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                    <i class="fas fa-database text-blue-600 text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Database Configuration
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Step 4: Set up your database connection
                </p>
            </div>

            <!-- Setup Progress -->
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
                            <p class="text-sm font-medium text-green-900">System Requirements</p>
                            <p class="text-xs text-green-600">Completed</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-900">Environment Setup</p>
                            <p class="text-xs text-green-600">Completed</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm font-medium">4</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Database Setup</p>
                            <p class="text-xs text-blue-600">In Progress</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">5</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Admin Setup</p>
                            <p class="text-xs text-gray-400">Next</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Form -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Database Connection</h3>
                    <p class="text-sm text-gray-600">Enter your database connection details</p>
                </div>
                
                <form method="POST" action="{{ route('install.database') }}" class="p-6 space-y-6">
                    @csrf
                    
                    <!-- Database Host -->
                    <div>
                        <label for="db_host" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-server mr-2 text-blue-500"></i>
                            Database Host
                        </label>
                        <input type="text" 
                               id="db_host" 
                               name="db_host" 
                               value="{{ old('db_host', $defaultConfig['db_host'] ?? '127.0.0.1') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="127.0.0.1 or localhost"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Usually 127.0.0.1 for local development or your database server IP</p>
                    </div>

                    <!-- Database Port -->
                    <div>
                        <label for="db_port" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-network-wired mr-2 text-blue-500"></i>
                            Database Port
                        </label>
                        <input type="number" 
                               id="db_port" 
                               name="db_port" 
                               value="{{ old('db_port', $defaultConfig['db_port'] ?? '3306') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="3306"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Default MySQL port is 3306, PostgreSQL is 5432</p>
                    </div>

                    <!-- Database Name -->
                    <div>
                        <label for="db_name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-database mr-2 text-blue-500"></i>
                            Database Name
                        </label>
                        <input type="text" 
                               id="db_name" 
                               name="db_name" 
                               value="{{ old('db_name', $defaultConfig['db_name'] ?? 'cms') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="your_database_name"
                               required>
                        <p class="mt-1 text-sm text-gray-500">The name of your database (create it first if it doesn't exist)</p>
                    </div>

                    <!-- Database Username -->
                    <div>
                        <label for="db_user" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Database Username
                        </label>
                        <input type="text" 
                               id="db_user" 
                               name="db_user" 
                               value="{{ old('db_user', $defaultConfig['db_user'] ?? 'cm_user') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="database_username"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Username with access to the database</p>
                    </div>

                    <!-- Database Password -->
                    <div>
                        <label for="db_pass" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>
                            Database Password
                        </label>
                        <input type="password" 
                               id="db_pass" 
                               name="db_pass" 
                               value="{{ old('db_pass', $defaultConfig['db_pass'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="database_password">
                        <p class="mt-1 text-sm text-gray-500">Password for the database user (leave empty if no password)</p>
                    </div>

                    <!-- Database Type -->
                    <div>
                        <label for="db_type" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-cog mr-2 text-blue-500"></i>
                            Database Type
                        </label>
                        <select id="db_type" 
                                name="db_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="mysql" {{ old('db_type', $defaultConfig['db_type'] ?? 'mysql') === 'mysql' ? 'selected' : '' }}>MySQL / MariaDB</option>
                            <option value="pgsql" {{ old('db_type', $defaultConfig['db_type'] ?? 'mysql') === 'pgsql' ? 'selected' : '' }}>PostgreSQL</option>
                            <option value="sqlite" {{ old('db_type', $defaultConfig['db_type'] ?? 'mysql') === 'sqlite' ? 'selected' : '' }}>SQLite</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Select your database management system</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-4">
                        <a href="{{ route('install.env') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Previous Step
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-database mr-2"></i>
                            Test Connection & Continue
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Database Setup Tips</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Create the database first</strong> in your database management system</li>
                                <li>Ensure the user has <strong>full permissions</strong> on the database</li>
                                <li>For local development, use <strong>127.0.0.1</strong> or <strong>localhost</strong></li>
                                <li>Test the connection before proceeding to the next step</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Database Configurations -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-lightbulb text-gray-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-800">Common Configurations</h3>
                        <div class="mt-2 text-sm text-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium">Local Development (XAMPP/WAMP)</h4>
                                    <p class="text-xs">Host: localhost<br>Port: 3306<br>User: root<br>Password: (empty)</p>
                                </div>
                                <div>
                                    <h4 class="font-medium">Shared Hosting</h4>
                                    <p class="text-xs">Host: localhost<br>Port: 3306<br>User: your_cpanel_user<br>Password: your_password</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 