<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the learner's profile.
     */
    public function show()
    {
        $learner = auth('learner')->user();
        
        return view('learner.profile.show', compact('learner'));
    }

    /**
     * Show the form for editing the learner's profile.
     */
    public function edit()
    {
        $learner = auth('learner')->user();
        
        return view('learner.profile.edit', compact('learner'));
    }

    /**
     * Update the learner's profile.
     */
    public function update(Request $request)
    {
        $learner = auth('learner')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:learners,email,' . $learner->id],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'required_with:current_password', 'confirmed', Password::min(8)],
        ]);

        // Update name and email
        $learner->name = $validated['name'];
        $learner->email = $validated['email'];

        // Update password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $learner->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            $learner->password = Hash::make($validated['new_password']);
        }

        $learner->save();

        return redirect()->route('learner.profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Toggle two-factor authentication for the learner.
     */
    public function toggleTwoFactor(Request $request)
    {
        $learner = auth('learner')->user();

        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
            'method' => ['nullable', 'string', 'in:email,sms'],
        ]);

        if ($validated['enabled']) {
            // Enable 2FA
            $method = $validated['method'] ?? 'email';
            $learner->enableTwoFactor($method);
            
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication has been enabled.',
            ]);
        } else {
            // Disable 2FA
            $learner->disableTwoFactor();
            
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication has been disabled.',
            ]);
        }
    }
}
