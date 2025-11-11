<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Learner;
use App\Mail\MagicLinkMail;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show the learner login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the learner registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle learner registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:learners'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $learner = Learner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('learner')->login($learner);
        
        // Handle certification-specific registration flow
        $certSlug = $request->input('cert');
        $quizAttemptId = $request->input('quiz');
        
        if ($certSlug && $quizAttemptId) {
            // Store in session for onboarding
            session([
                'onboarding_cert_slug' => $certSlug,
                'onboarding_quiz_attempt_id' => $quizAttemptId
            ]);
            
            // Track conversion
            $this->trackQuizConversion($quizAttemptId);
            
            // Redirect to certification-specific onboarding
            return redirect()->route('learner.certification.onboarding', $certSlug);
        }

        return redirect('/learner/dashboard');
    }
    
    /**
     * Track quiz conversion
     */
    protected function trackQuizConversion($attemptId)
    {
        try {
            $attempt = \App\Models\LandingQuizAttempt::find($attemptId);
            if ($attempt) {
                $attempt->converted_to_registration = true;
                $attempt->save();
            }
        } catch (\Exception $e) {
            // Silently fail - don't break registration flow
        }
    }

    /**
     * Handle learner login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find learner by email
        $learner = Learner::where('email', $credentials['email'])->first();

        // Verify password
        if (!$learner || !Hash::check($credentials['password'], $learner->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Check if 2FA is enabled
        if ($learner->hasTwoFactorEnabled()) {
            // Store learner ID in session for 2FA verification
            $request->session()->put('2fa_learner_id', $learner->id);
            $request->session()->put('2fa_remember', $request->boolean('remember'));
            
            // Mask email for display (show first 2 chars and domain)
            $email = $learner->email;
            $emailParts = explode('@', $email);
            $maskedEmail = substr($emailParts[0], 0, 2) . '******@' . $emailParts[1];
            $request->session()->put('two_factor_email_masked', $maskedEmail);
            
            // Send 2FA code
            $learner->sendTwoFactorCode();
            
            // Redirect to 2FA verification page
            return redirect()->route('auth.two-factor')->with('success', 'A verification code has been sent to your email.');
        }

        // No 2FA, proceed with normal login
        Auth::guard('learner')->login($learner, $request->boolean('remember'));
        $request->session()->regenerate();
        
        return redirect()->intended('/learner/dashboard');
    }

    /**
     * Handle learner logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('learner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Send password reset link
        $status = Password::broker('learners')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm($token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('learners')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($learner, $password) {
                $learner->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $learner->save();

                event(new PasswordReset($learner));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Send magic link for passwordless login.
     */
    public function sendMagicLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $learner = Learner::where('email', $request->email)->first();

        if (!$learner) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with that email address.'
            ], 404);
        }

        // Generate magic link token
        $token = Str::random(64);
        $learner->update([
            'magic_link_token' => $token,
            'magic_link_expires_at' => now()->addMinutes(15)
        ]);

        // Generate magic link URL
        $magicLinkUrl = route('auth.magic-link.verify', ['token' => $token]);
        
        // Send magic link email
        Mail::to($learner->email)->send(new MagicLinkMail($magicLinkUrl, $learner->name, 15));

        return response()->json([
            'success' => true,
            'message' => 'Magic link sent! Check your email to sign in.'
        ]);
    }

    /**
     * Verify magic link and log in user.
     */
    public function verifyMagicLink($token)
    {
        $learner = Learner::where('magic_link_token', $token)
            ->where('magic_link_expires_at', '>', now())
            ->first();

        if (!$learner) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid or expired magic link.']);
        }

        // Clear magic link token
        $learner->update([
            'magic_link_token' => null,
            'magic_link_expires_at' => null
        ]);

        Auth::guard('learner')->login($learner);

        return redirect('/learner/dashboard');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            return $this->handleSocialCallback($googleUser, 'google');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google authentication failed. Please try again.']);
        }
    }

    /**
     * Redirect to LinkedIn OAuth.
     */
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin-openid')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback.
     */
    public function handleLinkedInCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin-openid')->user();
            return $this->handleSocialCallback($linkedinUser, 'linkedin');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'LinkedIn authentication failed. Please try again.']);
        }
    }

    /**
     * Redirect to Facebook OAuth.
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback.
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            return $this->handleSocialCallback($facebookUser, 'facebook');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Facebook authentication failed. Please try again.']);
        }
    }

    /**
     * Handle social authentication callback (unified method).
     */
    protected function handleSocialCallback($socialUser, $provider)
    {
        // Find or create learner
        $learner = Learner::where('email', $socialUser->getEmail())->first();

        if (!$learner) {
            // Create new learner account
            $learner = Learner::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(32)), // Random password for social auth users
                'email_verified_at' => now(), // Auto-verify email for social auth
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        } else {
            // Update provider info if not set
            if (!$learner->provider) {
                $learner->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'email_verified_at' => $learner->email_verified_at ?? now(),
                ]);
            }
        }

        Auth::guard('learner')->login($learner);

        return redirect('/learner/dashboard');
    }

    /**
     * Show email verification notice.
     */
    public function showVerifyEmailForm()
    {
        return view('auth.verify-email');
    }

    /**
     * Verify email address.
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $learner = Learner::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($learner->email))) {
            return redirect()->route('learner.dashboard')
                ->withErrors(['email' => 'Invalid verification link.']);
        }

        if ($learner->hasVerifiedEmail()) {
            return redirect()->route('learner.dashboard');
        }

        $learner->markEmailAsVerified();

        return redirect()->route('learner.dashboard')
            ->with('success', 'Email verified successfully!');
    }

    /**
     * Resend email verification.
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user('learner')->hasVerifiedEmail()) {
            return redirect()->route('learner.dashboard');
        }

        $request->user('learner')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    /**
     * Show two-factor authentication form.
     */
    public function showTwoFactorForm()
    {
        // Check if 2FA session exists
        if (!session()->has('2fa_learner_id')) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'Please login first.']);
        }

        return view('auth.two-factor');
    }

    /**
     * Verify two-factor authentication code.
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        // Get learner ID from session
        $learnerId = session('2fa_learner_id');
        if (!$learnerId) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $learner = Learner::find($learnerId);
        if (!$learner) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'User not found.']);
        }

        // Verify the code
        if ($learner->verifyTwoFactorCode($request->code)) {
            // Code is valid, complete login
            $remember = session('2fa_remember', false);
            Auth::guard('learner')->login($learner, $remember);
            
            // Clear 2FA session data
            session()->forget(['2fa_learner_id', '2fa_remember']);
            
            // Regenerate session
            $request->session()->regenerate();
            
            return redirect()->intended('/learner/dashboard')
                ->with('success', 'Login successful!');
        } else {
            // Code is invalid or expired
            return back()->withErrors([
                'code' => 'Invalid or expired verification code. Please try again.',
            ]);
        }
    }

    /**
     * Resend two-factor authentication code.
     */
    public function resendTwoFactorCode(Request $request)
    {
        // Get learner ID from session
        $learnerId = session('2fa_learner_id');
        if (!$learnerId) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'Session expired. Please login again.']);
        }

        $learner = Learner::find($learnerId);
        if (!$learner) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'User not found.']);
        }

        // Send new code
        $learner->sendTwoFactorCode();

        return back()->with('success', 'A new verification code has been sent to your email.');
    }

    /**
     * Verify two-factor authentication via email link.
     */
    public function verifyTwoFactorLink(Request $request, $code)
    {
        // Check if 2FA session exists
        if (!session()->has('2fa_learner_id')) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'Session expired. Please login again.']);
        }

        // Get learner ID from session
        $learnerId = session('2fa_learner_id');
        $learner = Learner::find($learnerId);
        
        if (!$learner) {
            return redirect()->route('auth.login')
                ->withErrors(['error' => 'User not found.']);
        }

        // Verify the code
        if ($learner->verifyTwoFactorCode($code)) {
            // Code is valid, complete login
            $remember = session('2fa_remember', false);
            Auth::guard('learner')->login($learner, $remember);
            
            // Clear 2FA session data
            session()->forget(['2fa_learner_id', '2fa_remember', 'two_factor_email_masked']);
            
            // Regenerate session
            $request->session()->regenerate();
            
            return redirect()->intended('/learner/dashboard')
                ->with('success', 'Login successful!');
        } else {
            // Code is invalid or expired, redirect to 2FA page with error
            return redirect()->route('auth.two-factor')
                ->withErrors(['code' => 'Invalid or expired verification link. Please enter the code manually.']);
        }
    }
}
