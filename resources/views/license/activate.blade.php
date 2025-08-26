<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Activation - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                    <i class="fas fa-key text-blue-600 text-xl"></i>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Welcome to {{ config('app.name', 'Laravel') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Step 1: Activate your license to get started
                </p>
            </div>

            <!-- Setup Flow Steps -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Setup Process</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm font-medium">1</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">License Activation</p>
                            <p class="text-xs text-gray-500">Enter your license key</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">2</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">System Installation</p>
                            <p class="text-xs text-gray-400">Configure database & admin</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-400 text-sm font-medium">3</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-400">Ready to Use</p>
                            <p class="text-xs text-gray-400">Access your application</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <form class="mt-8 space-y-6" method="POST" action="{{ route('license.activate.post') }}">
                @csrf
                
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="license_key" class="sr-only">License Key</label>
                        <input id="license_key" name="license_key" type="text" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                               placeholder="XXXX-XXXX-XXXX-XXXX"
                               value="{{ old('license_key') }}">
                    </div>
                    <div>
                        <label for="purchase_code" class="sr-only">Purchase Code</label>
                        <input id="purchase_code" name="purchase_code" type="text" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                               placeholder="Purchase Code"
                               value="{{ old('purchase_code') }}">
                    </div>
                    <div>
                        <label for="buyer_email" class="sr-only">Buyer Email</label>
                        <input id="buyer_email" name="buyer_email" type="email" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                               placeholder="Buyer Email"
                               value="{{ old('buyer_email') }}">
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-unlock"></i>
                        </span>
                        Activate License & Continue
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have a license? 
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Purchase one here
                        </a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        <a href="{{ route('demo.purchase-info') }}" class="font-medium text-green-600 hover:text-green-500">
                            <i class="fas fa-eye mr-1"></i>View Demo Purchase Information
                        </a>
                    </p>
                </div>
            </form>

            <!-- Demo License Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Demo License Keys</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>For testing purposes, you can use these demo license keys:</p>
                            <ul class="mt-1 list-disc list-inside">
                                <li><strong>DEMO-1234-5678-9ABC</strong> - Regular License (1 year)</li>
                                <li><strong>TEST-ABCD-EFGH-IJKL</strong> - Lifetime License</li>
                            </ul>
                            <p class="mt-2">Use any email and purchase code with these demo keys.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What Happens Next -->
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-arrow-right text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">What Happens Next?</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>After license activation, you'll be redirected to the installation wizard where you can:</p>
                            <ul class="mt-1 list-disc list-inside">
                                <li>Configure your database</li>
                                <li>Create admin account</li>
                                <li>Set up your application</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 