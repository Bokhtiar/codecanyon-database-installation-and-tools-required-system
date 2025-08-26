<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::latest()->paginate(15);
        return view('admin.licenses.index', compact('licenses'));
    }

    public function create()
    {
        return view('admin.licenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string|unique:licenses',
            'domain' => 'required|string',
            'purchase_code' => 'required|string',
            'buyer_email' => 'required|email',
            'item_id' => 'required|string',
            'item_name' => 'required|string',
            'license_type' => 'required|in:regular,extended,lifetime',
            'expires_at' => 'nullable|date|after:today',
            'support_until' => 'nullable|date|after:today',
        ]);

        $license = License::create([
            'license_key' => strtoupper($request->license_key),
            'domain' => $request->domain,
            'status' => License::STATUS_PENDING,
            'purchase_code' => $request->purchase_code,
            'buyer_email' => $request->buyer_email,
            'item_id' => $request->item_id,
            'item_name' => $request->item_name,
            'license_type' => $request->license_type,
            'expires_at' => $request->expires_at,
            'support_until' => $request->support_until,
        ]);

        // Verify the license
        if ($license->verify()) {
            return redirect()->route('admin.licenses.index')->with('success', 'License created and verified successfully!');
        } else {
            return redirect()->route('admin.licenses.index')->with('warning', 'License created but verification failed. Please check the license key.');
        }
    }

    public function show(License $license)
    {
        return view('admin.licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        return view('admin.licenses.edit', compact('license'));
    }

    public function update(Request $request, License $license)
    {
        $request->validate([
            'domain' => 'required|string',
            'purchase_code' => 'required|string',
            'buyer_email' => 'required|email',
            'item_id' => 'required|string',
            'item_name' => 'required|string',
            'license_type' => 'required|in:regular,extended,lifetime',
            'expires_at' => 'nullable|date',
            'support_until' => 'nullable|date',
        ]);

        $license->update($request->only([
            'domain', 'purchase_code', 'buyer_email', 'item_id', 
            'item_name', 'license_type', 'expires_at', 'support_until'
        ]));

        return redirect()->route('admin.licenses.index')->with('success', 'License updated successfully!');
    }

    public function destroy(License $license)
    {
        $license->delete();
        return redirect()->route('admin.licenses.index')->with('success', 'License deleted successfully!');
    }

    public function verify(License $license)
    {
        if ($license->verify()) {
            return back()->with('success', 'License verified successfully!');
        } else {
            return back()->with('error', 'License verification failed. Please check the license key.');
        }
    }

    public function activate(License $license)
    {
        $license->update(['status' => License::STATUS_ACTIVE]);
        return back()->with('success', 'License activated successfully!');
    }

    public function deactivate(License $license)
    {
        $license->update(['status' => License::STATUS_INACTIVE]);
        return back()->with('success', 'License deactivated successfully!');
    }

    public function bulkVerify()
    {
        $licenses = License::where('status', '!=', License::STATUS_ACTIVE)->get();
        $verified = 0;
        $failed = 0;

        foreach ($licenses as $license) {
            if ($license->verify()) {
                $verified++;
            } else {
                $failed++;
            }
        }

        return back()->with('success', "Bulk verification completed: {$verified} verified, {$failed} failed.");
    }
} 