<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicenseController extends Controller
{
    public function showActivation()
    {
        // Check if already has valid license
        if (LicenseService::hasValidLicense()) {
            return redirect('/')->with('success', 'License is already active!');
        }

        return view('license.activate');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
            'purchase_code' => 'required|string',
            'buyer_email' => 'required|email',
        ]);

        try {
            // Validate license key format
            if (!LicenseService::isValidLicenseKeyFormat($request->license_key)) {
                return back()->withErrors(['license_key' => 'Invalid license key format. Expected format: XXXX-XXXX-XXXX-XXXX']);
            }

            // Verify license with external service
            $verificationResult = LicenseService::verifyLicense(
                $request->license_key,
                request()->getHost()
            );

            if (!$verificationResult['success']) {
                return back()->withErrors(['license_key' => $verificationResult['message']]);
            }

            // For demo purposes, store license info in session instead of database
            // This allows the system to work without database configuration
            $licenseData = [
                'license_key' => strtoupper($request->license_key),
                'domain' => request()->getHost(),
                'status' => $verificationResult['status'],
                'purchase_code' => $request->purchase_code,
                'buyer_email' => $request->buyer_email,
                'item_id' => $verificationResult['item_id'] ?? 'DEMO-ITEM',
                'item_name' => $verificationResult['item_name'] ?? 'Demo Application',
                'license_type' => $verificationResult['license_type'] ?? 'regular',
                'expires_at' => $verificationResult['expires_at'] ?? null,
                'support_until' => $verificationResult['support_until'] ?? null,
                'verified_at' => now(),
            ];

            // Store in session for demo purposes
            session(['demo_license' => $licenseData]);

            Log::info('Demo license activated successfully', [
                'license_key' => $licenseData['license_key'],
                'domain' => $licenseData['domain'],
                'buyer_email' => $licenseData['buyer_email']
            ]);

            return redirect('/install')->with('success', 'License activated successfully! Now let\'s set up your application.');

        } catch (\Exception $e) {
            Log::error('License activation failed: ' . $e->getMessage());
            return back()->withErrors(['general' => 'License activation failed. Please try again or contact support.']);
        }
    }

    public function showStatus()
    {
        $license = LicenseService::getCurrentLicense();
        
        if (!$license) {
            return redirect()->route('license.activate')->with('error', 'No license found. Please activate your license.');
        }

        return view('license.status', compact('license'));
    }

    public function verify()
    {
        $license = LicenseService::getCurrentLicense();
        
        if (!$license) {
            return back()->with('error', 'No license found to verify.');
        }

        if ($license->verify()) {
            return back()->with('success', 'License verified successfully!');
        } else {
            return back()->with('error', 'License verification failed. Please check your license key.');
        }
    }

    public function deactivate()
    {
        $license = LicenseService::getCurrentLicense();
        
        if (!$license) {
            return back()->with('error', 'No license found to deactivate.');
        }

        $license->update(['status' => 'inactive']);
        
        return redirect()->route('license.activate')->with('success', 'License deactivated successfully. Please reactivate to continue using the application.');
    }
} 