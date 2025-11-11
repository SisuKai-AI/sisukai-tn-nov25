<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the admin's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the admin's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // Verify current password if changing password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
        }

        // Update name and email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Toggle two-factor authentication for the admin.
     */
    public function toggleTwoFactor(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
            'method' => ['nullable', 'string', 'in:email,sms'],
        ]);

        if ($validated['enabled']) {
            // Enable 2FA
            $method = $validated['method'] ?? 'email';
            $user->enableTwoFactor($method);
            
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication has been enabled.',
            ]);
        } else {
            // Disable 2FA
            $user->disableTwoFactor();
            
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication has been disabled.',
            ]);
        }
    }
}
