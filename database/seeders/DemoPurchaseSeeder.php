<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\License;

class DemoPurchaseSeeder extends Seeder
{
    public function run()
    {
        $demoPurchases = [
            [
                'license_key' => 'DEMO-1234-5678-9ABC',
                'domain' => 'localhost',
                'status' => 'active',
                'purchase_code' => 'DEMO-PURCHASE-001',
                'buyer_email' => 'john.doe@example.com',
                'item_id' => 'DEMO-ITEM-001',
                'item_name' => 'Premium Admin Dashboard Template',
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
                'buyer_email' => 'jane.smith@company.com',
                'item_id' => 'TEST-ITEM-002',
                'item_name' => 'Enterprise CMS System',
                'license_type' => 'lifetime',
                'expires_at' => null, // Lifetime
                'support_until' => null, // Lifetime support
                'verified_at' => now(),
            ],
            [
                'license_key' => 'PREMIUM-2024-XXXX-YYYY',
                'domain' => 'demo.mysite.com',
                'status' => 'active',
                'purchase_code' => 'PREMIUM-PURCHASE-003',
                'buyer_email' => 'admin@startup.com',
                'item_id' => 'PREMIUM-ITEM-003',
                'item_name' => 'Startup Business Management Suite',
                'license_type' => 'extended',
                'expires_at' => now()->addYears(2),
                'support_until' => now()->addYear(),
                'verified_at' => now(),
            ],
            [
                'license_key' => 'STUDENT-2024-XXXX-YYYY',
                'domain' => 'localhost',
                'status' => 'active',
                'purchase_code' => 'STUDENT-PURCHASE-004',
                'buyer_email' => 'student@university.edu',
                'item_id' => 'STUDENT-ITEM-004',
                'item_name' => 'Student Project Management Tool',
                'license_type' => 'regular',
                'expires_at' => now()->addMonths(6),
                'support_until' => now()->addMonths(3),
                'verified_at' => now(),
            ],
            [
                'license_key' => 'ENTERPRISE-2024-XXXX-YYYY',
                'domain' => 'corp.bigcompany.com',
                'status' => 'active',
                'purchase_code' => 'ENTERPRISE-PURCHASE-005',
                'buyer_email' => 'it.manager@bigcompany.com',
                'item_id' => 'ENTERPRISE-ITEM-005',
                'item_name' => 'Corporate Resource Management System',
                'license_type' => 'lifetime',
                'expires_at' => null,
                'support_until' => null,
                'verified_at' => now(),
            ]
        ];

        foreach ($demoPurchases as $purchase) {
            License::create($purchase);
        }
    }
} 