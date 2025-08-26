<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\License;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        $licenses = [
            [
                'license_key' => 'DEMO-1234-5678-9ABC',
                'domain' => 'localhost',
                'status' => 'active',
                'purchase_code' => 'DEMO-PURCHASE-001',
                'buyer_email' => 'demo@example.com',
                'item_id' => 'DEMO-ITEM-001',
                'item_name' => 'Demo Application',
                'license_type' => 'regular',
                'expires_at' => now()->addYear(),
                'support_until' => now()->addMonths(6),
                'verified_at' => now(),
            ],
            [
                'license_key' => 'TEST-ABCD-EFGH-IJKL',
                'domain' => '127.0.0.1',
                'status' => 'active',
                'purchase_code' => 'TEST-PURCHASE-002',
                'buyer_email' => 'test@example.com',
                'item_id' => 'TEST-ITEM-002',
                'item_name' => 'Test Application',
                'license_type' => 'lifetime',
                'expires_at' => null, // Lifetime
                'support_until' => null, // Lifetime support
                'verified_at' => now(),
            ]
        ];

        foreach ($licenses as $license) {
            License::create($license);
        }
    }
} 