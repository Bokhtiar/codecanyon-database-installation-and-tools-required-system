<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - {{ config('app.name', 'Laravel') }}</title>
    
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
                    Installation Wizard
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Step 2: System Installation
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
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm font-medium">2</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">System Installation</p>
                            <p class="text-xs text-blue-600">In Progress</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">3</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Ready to Use</p>
                            <p class="text-xs text-gray-400">Configure database & admin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome to {{ config('app.name', 'Laravel') }}</h3>
                    <p class="text-gray-600 mb-6">
                        Your license has been activated successfully! Now let's set up your application. 
                        This wizard will guide you through the installation process.
                    </p>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <i class="fas fa-database mr-2 text-blue-500"></i>
                            Database Configuration
                        </div>
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <i class="fas fa-user-shield mr-2 text-blue-500"></i>
                            Admin Account Setup
                        </div>
                        <div class="flex items-center justify-center text-sm text-gray-600">
                            <i class="fas fa-cog mr-2 text-blue-500"></i>
                            System Configuration
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Step Button -->
            <div class="text-center">
                <a href="{{ route('install.requirements') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Start Installation
                </a>
            </div>

            <!-- Back to License -->
            <div class="text-center">
                <a href="{{ route('license.status') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    <i class="fas fa-key mr-1"></i>
                    View License Status
                </a>
            </div>
        </div>
    </div>
</body>
</html>
