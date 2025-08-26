<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function purchaseInfo()
    {
        // Get all demo licenses
        $licenses = License::all();
        
        // Group licenses by type
        $licenseTypes = [
            'regular' => $licenses->where('license_type', 'regular'),
            'extended' => $licenses->where('license_type', 'extended'),
            'lifetime' => $licenses->where('license_type', 'lifetime'),
        ];
        
        // Demo purchase codes for easy copying
        $demoCodes = [
            'DEMO-1234-5678-9ABC' => [
                'type' => 'Regular License',
                'purchase_code' => 'DEMO-PURCHASE-001',
                'email' => 'john.doe@example.com',
                'description' => '1 year license with 6 months support'
            ],
            'TEST-ABCD-EFGH-IJKL' => [
                'type' => 'Lifetime License',
                'purchase_code' => 'TEST-PURCHASE-002',
                'email' => 'jane.smith@company.com',
                'description' => 'Never expires with lifetime support'
            ],
            'PREMIUM-2024-XXXX-YYYY' => [
                'type' => 'Extended License',
                'purchase_code' => 'PREMIUM-PURCHASE-003',
                'email' => 'admin@startup.com',
                'description' => '2 years license with 1 year support'
            ]
        ];
        
        return view('demo.purchase-info', compact('licenses', 'licenseTypes', 'demoCodes'));
    }
    
    public function licenseExamples()
    {
        // Show different license status examples
        $examples = [
            'active' => [
                'status' => 'Active',
                'color' => 'green',
                'icon' => 'check',
                'description' => 'License is valid and working properly'
            ],
            'inactive' => [
                'status' => 'Inactive',
                'color' => 'red',
                'icon' => 'times',
                'description' => 'License is disabled or suspended'
            ],
            'expired' => [
                'status' => 'Expired',
                'color' => 'yellow',
                'icon' => 'exclamation-triangle',
                'description' => 'License has expired and needs renewal'
            ],
            'pending' => [
                'status' => 'Pending',
                'color' => 'blue',
                'icon' => 'clock',
                'description' => 'License is being verified'
            ]
        ];
        
        return view('demo.license-examples', compact('examples'));
    }
} 