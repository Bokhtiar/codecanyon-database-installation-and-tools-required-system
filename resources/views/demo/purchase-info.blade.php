<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Purchase Information - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    🗝️ Demo Purchase Information
                </h1>
                <p class="text-lg text-gray-600">
                    Realistic examples of how purchase codes and license information will look
                </p>
            </div>

            <!-- Demo License Keys Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-key text-blue-500 mr-2"></i>
                    Demo License Keys for Testing
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Demo Key 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-500">Regular License</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs font-medium text-gray-500">License Key:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">DEMO-1234-5678-9ABC</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Purchase Code:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">DEMO-PURCHASE-001</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Buyer Email:</label>
                                <p class="text-sm text-gray-900">john.doe@example.com</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Item Name:</label>
                                <p class="text-sm text-gray-900">Premium Admin Dashboard Template</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Expires:</label>
                                <p class="text-sm text-gray-900">1 year from now</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Support:</label>
                                <p class="text-sm text-gray-900">6 months</p>
                            </div>
                        </div>
                    </div>

                    <!-- Demo Key 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-500">Lifetime License</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs font-medium text-gray-500">License Key:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">TEST-ABCD-EFGH-IJKL</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Purchase Code:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">TEST-PURCHASE-002</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Buyer Email:</label>
                                <p class="text-sm text-gray-900">jane.smith@company.com</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Item Name:</label>
                                <p class="text-sm text-gray-900">Enterprise CMS System</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Expires:</label>
                                <p class="text-sm text-green-600 font-medium">Never (Lifetime)</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Support:</label>
                                <p class="text-sm text-green-600 font-medium">Lifetime</p>
                            </div>
                        </div>
                    </div>

                    <!-- Demo Key 3 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-500">Extended License</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs font-medium text-gray-500">License Key:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">PREMIUM-2024-XXXX-YYYY</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Purchase Code:</label>
                                <p class="text-sm font-mono text-gray-900 bg-gray-50 p-2 rounded">PREMIUM-PURCHASE-003</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Buyer Email:</label>
                                <p class="text-sm text-gray-900">admin@startup.com</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Item Name:</label>
                                <p class="text-sm text-gray-900">Startup Business Management Suite</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Expires:</label>
                                <p class="text-sm text-gray-900">2 years from now</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-500">Support:</label>
                                <p class="text-sm text-gray-900">1 year</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Information Examples -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-shopping-cart text-green-500 mr-2"></i>
                    Purchase Information Examples
                </h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Regular
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">DEMO-PURCHASE-001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">john.doe@example.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Premium Admin Dashboard Template</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">localhost</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Lifetime
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">TEST-PURCHASE-002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">jane.smith@company.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Enterprise CMS System</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">127.0.0.1</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Extended
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">PREMIUM-PURCHASE-003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin@startup.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Startup Business Management Suite</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">demo.mysite.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Regular
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">STUDENT-PURCHASE-004</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">student@university.edu</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Student Project Management Tool</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">localhost</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Lifetime
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">ENTERPRISE-PURCHASE-005</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">it.manager@bigcompany.com</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Corporate Resource Management System</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">corp.bigcompany.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- License Status Examples -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    License Status Examples
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Active</h3>
                        <p class="text-sm text-gray-600">License is valid and working</p>
                    </div>
                    
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-times text-red-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Inactive</h3>
                        <p class="text-sm text-gray-600">License is disabled</p>
                    </div>
                    
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="w-16 h-16 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Expired</h3>
                        <p class="text-sm text-gray-600">License has expired</p>
                    </div>
                    
                    <div class="text-center p-4 border border-gray-200 rounded-lg">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-pause text-gray-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Suspended</h3>
                        <p class="text-sm text-gray-600">License is suspended</p>
                    </div>
                </div>
            </div>

            <!-- How to Use Demo Keys -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-4">
                    <i class="fas fa-lightbulb text-blue-500 mr-2"></i>
                    How to Use Demo Keys
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <span class="text-blue-600 text-xs font-medium">1</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Go to License Activation</p>
                            <p class="text-xs text-blue-700">Visit <code class="bg-blue-100 px-1 rounded">/license/activate</code></p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <span class="text-blue-600 text-xs font-medium">2</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Enter Demo Information</p>
                            <p class="text-xs text-blue-700">Use any of the demo license keys above with any email and purchase code</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                            <span class="text-blue-600 text-xs font-medium">3</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-900">Continue to Installation</p>
                            <p class="text-xs text-blue-700">After activation, you'll be redirected to the installation wizard</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-y-4">
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('license.activate') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-key mr-2"></i>
                        Try License Activation
                    </a>
                    
                    <a href="/" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-home mr-2"></i>
                        Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 