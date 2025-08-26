<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class License extends Model
{
    protected $fillable = [
        'license_key',
        'domain',
        'status',
        'expires_at',
        'verified_at',
        'purchase_code',
        'buyer_email',
        'item_id',
        'item_name',
        'support_until',
        'license_type'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'support_until' => 'datetime'
    ];

    // License statuses
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_EXPIRED = 'expired';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_PENDING = 'pending';

    // License types
    const TYPE_REGULAR = 'regular';
    const TYPE_EXTENDED = 'extended';
    const TYPE_LIFETIME = 'lifetime';

    public function isValid()
    {
        return $this->status === self::STATUS_ACTIVE && 
               ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function needsRenewal()
    {
        if ($this->expires_at === null) return false;
        
        // Check if license expires within 30 days
        return $this->expires_at->diffInDays(now()) <= 30;
    }

    public function verify()
    {
        try {
            // Check if we have a cached verification
            $cacheKey = "license_verification_{$this->license_key}";
            $cached = Cache::get($cacheKey);
            
            if ($cached && $cached['verified_at']->diffInHours(now()) < 24) {
                // Use cached verification if less than 24 hours old
                $this->update([
                    'status' => $cached['status'],
                    'verified_at' => $cached['verified_at']
                ]);
                return true;
            }

            // Perform new verification
            $verificationResult = $this->performVerification();
            
            if ($verificationResult['success']) {
                $this->update([
                    'status' => $verificationResult['status'],
                    'verified_at' => now(),
                    'expires_at' => $verificationResult['expires_at'] ?? null,
                    'support_until' => $verificationResult['support_until'] ?? null
                ]);

                // Cache the verification result
                Cache::put($cacheKey, [
                    'status' => $verificationResult['status'],
                    'verified_at' => now()
                ], now()->addHours(24));

                return true;
            }

            return false;

        } catch (\Exception $e) {
            \Log::error('License verification failed: ' . $e->getMessage());
            return false;
        }
    }

    private function performVerification()
    {
        // Simulate Codecanyon verification API
        // In real implementation, this would call Codecanyon's API
        
        $response = [
            'success' => false,
            'message' => 'Verification failed',
            'status' => self::STATUS_INACTIVE
        ];

        try {
            // Check if license key format is valid
            if (!$this->isValidLicenseKeyFormat()) {
                $response['message'] = 'Invalid license key format';
                return $response;
            }

            // Check domain validation
            if (!$this->isValidDomain()) {
                $response['message'] = 'Domain not authorized for this license';
                return $response;
            }

            // Simulate API call to verification service
            $verificationData = $this->callVerificationAPI();
            
            if ($verificationData) {
                $response = [
                    'success' => true,
                    'status' => $verificationData['status'],
                    'expires_at' => $verificationData['expires_at'] ?? null,
                    'support_until' => $verificationData['support_until'] ?? null,
                    'message' => 'License verified successfully'
                ];
            }

        } catch (\Exception $e) {
            $response['message'] = 'Verification service unavailable';
        }

        return $response;
    }

    private function isValidLicenseKeyFormat()
    {
        // License key format: XXXX-XXXX-XXXX-XXXX
        return preg_match('/^[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}$/', $this->license_key);
    }

    private function isValidDomain()
    {
        $currentDomain = request()->getHost();
        $allowedDomains = [$this->domain, 'localhost', '127.0.0.1'];
        
        return in_array($currentDomain, $allowedDomains);
    }

    private function callVerificationAPI()
    {
        // Simulate API response
        // In real implementation, this would be a real API call
        
        $demoLicenses = [
            'DEMO-1234-5678-9ABC' => [
                'status' => self::STATUS_ACTIVE,
                'expires_at' => now()->addYear(),
                'support_until' => now()->addMonths(6)
            ],
            'TEST-ABCD-EFGH-IJKL' => [
                'status' => self::STATUS_ACTIVE,
                'expires_at' => null, // Lifetime
                'support_until' => null
            ]
        ];

        return $demoLicenses[$this->license_key] ?? null;
    }

    public function getStatusBadge()
    {
        $badges = [
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_INACTIVE => 'bg-red-100 text-red-800',
            self::STATUS_EXPIRED => 'bg-yellow-100 text-yellow-800',
            self::STATUS_SUSPENDED => 'bg-gray-100 text-gray-800',
            self::STATUS_PENDING => 'bg-blue-100 text-blue-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getDaysUntilExpiry()
    {
        if ($this->expires_at === null) return null;
        return max(0, $this->expires_at->diffInDays(now()));
    }

    public function getSupportStatus()
    {
        if ($this->support_until === null) return 'Lifetime Support';
        
        if ($this->support_until->isPast()) {
            return 'Support Expired';
        }
        
        $daysLeft = $this->support_until->diffInDays(now());
        if ($daysLeft <= 30) {
            return "Support expires in {$daysLeft} days";
        }
        
        return 'Support Active';
    }
} 