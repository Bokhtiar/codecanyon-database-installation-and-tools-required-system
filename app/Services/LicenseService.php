<?php

namespace App\Services;

use App\Models\License;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LicenseService
{
    /**
     * Check if the system has a valid license
     */
    public static function hasValidLicense()
    {
        try {
            // First check if we have a demo license in session (for demo purposes)
            if (session('demo_license')) {
                $demoLicense = session('demo_license');
                return $demoLicense['status'] === 'active';
            }

            // If no demo license, try database (for production)
            $license = License::where('domain', request()->getHost())
                             ->orWhere('domain', 'localhost')
                             ->orWhere('domain', '127.0.0.1')
                             ->first();

            if (!$license) {
                return false;
            }

            return $license->isValid();
        } catch (\Exception $e) {
            Log::error('License check failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get current license information
     */
    public static function getCurrentLicense()
    {
        try {
            // First check if we have a demo license in session (for demo purposes)
            if (session('demo_license')) {
                return (object) session('demo_license');
            }

            // If no demo license, try database (for production)
            return License::where('domain', request()->getHost())
                         ->orWhere('domain', 'localhost')
                         ->orWhere('domain', '127.0.0.1')
                         ->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Verify license with external service
     */
    public static function verifyLicense($licenseKey, $domain)
    {
        try {
            // Check cache first
            $cacheKey = "license_verification_{$licenseKey}_{$domain}";
            $cached = Cache::get($cacheKey);
            
            if ($cached && $cached['verified_at']->diffInHours(now()) < 24) {
                return $cached;
            }

            // Perform verification
            $verificationResult = self::callVerificationAPI($licenseKey, $domain);
            
            // Cache the result
            Cache::put($cacheKey, $verificationResult, now()->addHours(24));
            
            return $verificationResult;

        } catch (\Exception $e) {
            Log::error('License verification failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Verification service unavailable',
                'status' => 'error'
            ];
        }
    }

    /**
     * Call external verification API
     */
    private static function callVerificationAPI($licenseKey, $domain)
    {
        // Simulate Codecanyon verification API
        // In real implementation, this would be a real API call
        
        $demoLicenses = [
            'DEMO-1234-5678-9ABC' => [
                'success' => true,
                'status' => License::STATUS_ACTIVE,
                'message' => 'License verified successfully',
                'expires_at' => now()->addYear(),
                'support_until' => now()->addMonths(6),
                'license_type' => 'regular',
                'item_name' => 'Demo Application',
                'buyer_email' => 'demo@example.com'
            ],
            'TEST-ABCD-EFGH-IJKL' => [
                'success' => true,
                'status' => License::STATUS_ACTIVE,
                'message' => 'License verified successfully',
                'expires_at' => null, // Lifetime
                'support_until' => null, // Lifetime support
                'license_type' => 'lifetime',
                'item_name' => 'Test Application',
                'buyer_email' => 'test@example.com'
            ],
            'INVALID-KEY-TEST-123' => [
                'success' => false,
                'status' => License::STATUS_INACTIVE,
                'message' => 'Invalid license key',
                'expires_at' => null,
                'support_until' => null,
                'license_type' => null,
                'item_name' => null,
                'buyer_email' => null
            ]
        ];

        return $demoLicenses[$licenseKey] ?? [
            'success' => false,
            'status' => License::STATUS_INACTIVE,
            'message' => 'License key not found',
            'expires_at' => null,
            'support_until' => null,
            'license_type' => null,
            'item_name' => null,
            'buyer_email' => null
        ];
    }

    /**
     * Check if license needs renewal
     */
    public static function needsRenewal()
    {
        $license = self::getCurrentLicense();
        return $license ? $license->needsRenewal() : false;
    }

    /**
     * Get license expiry warning
     */
    public static function getExpiryWarning()
    {
        $license = self::getCurrentLicense();
        if (!$license || !$license->expires_at) {
            return null;
        }

        $daysUntilExpiry = $license->getDaysUntilExpiry();
        
        if ($daysUntilExpiry <= 7) {
            return [
                'type' => 'danger',
                'message' => "Your license expires in {$daysUntilExpiry} days! Please renew to continue using the application."
            ];
        } elseif ($daysUntilExpiry <= 30) {
            return [
                'type' => 'warning',
                'message' => "Your license expires in {$daysUntilExpiry} days. Consider renewing soon."
            ];
        }

        return null;
    }

    /**
     * Validate license key format
     */
    public static function isValidLicenseKeyFormat($licenseKey)
    {
        return preg_match('/^[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}$/', strtoupper($licenseKey));
    }

    /**
     * Generate demo license key
     */
    public static function generateDemoLicenseKey()
    {
        $segments = [];
        for ($i = 0; $i < 4; $i++) {
            $segments[] = strtoupper(substr(md5(uniqid()), 0, 4));
        }
        return implode('-', $segments);
    }
} 