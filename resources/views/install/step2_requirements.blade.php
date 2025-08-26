<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirements Check - {{ config('app.name', 'Laravel') }}</title>
    
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
                    <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    System Requirements Check
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Step 2: Verifying your server meets the requirements
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
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm font-medium">2</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">System Requirements</p>
                            <p class="text-xs text-blue-600">In Progress</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">3</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Environment Setup</p>
                            <p class="text-xs text-gray-400">Next</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">4</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Database Setup</p>
                            <p class="text-xs text-gray-400">Pending</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">5</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Admin Setup</p>
                            <p class="text-xs text-gray-400">Pending</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements Check -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Server Requirements</h3>
                    <p class="text-sm text-gray-600">Your server must meet these requirements to run the application</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- PHP Version -->
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-code text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">PHP Version</h4>
                                <p class="text-sm text-gray-500">Minimum: PHP 8.1 or higher</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if(version_compare(PHP_VERSION, '8.1.0', '>='))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    {{ PHP_VERSION }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    {{ PHP_VERSION }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- PHP Extensions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $extensions = [
                                'BCMath' => 'bcmath',
                                'Ctype' => 'ctype',
                                'JSON' => 'json',
                                'Mbstring' => 'mbstring',
                                'OpenSSL' => 'openssl',
                                'PDO' => 'pdo',
                                'Tokenizer' => 'tokenizer',
                                'XML' => 'xml',
                                'Fileinfo' => 'fileinfo',
                                'GD' => 'gd',
                                'cURL' => 'curl',
                                'Zip' => 'zip'
                            ];
                        @endphp

                        @foreach($extensions as $name => $extension)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-puzzle-piece text-gray-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $name }}</h4>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    @if(extension_loaded($extension))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Installed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i>
                                            Missing
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Directory Permissions -->
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Directory Permissions</h4>
                        <div class="space-y-3">
                            @php
                                $directories = [
                                    'storage/app' => storage_path('app'),
                                    'storage/framework' => storage_path('framework'),
                                    'storage/logs' => storage_path('logs'),
                                    'bootstrap/cache' => base_path('bootstrap/cache')
                                ];
                            @endphp

                            @foreach($directories as $name => $path)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-folder text-gray-600 text-xs"></i>
                                        </div>
                                        <div class="ml-3">
                                            <span class="text-sm text-gray-900">{{ $name }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @if(is_writable($path))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Writable
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>
                                                Not Writable
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('install.welcome') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Previous Step
                </a>
                
                <a href="{{ route('install.env') }}" 
                   class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Next Step
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
