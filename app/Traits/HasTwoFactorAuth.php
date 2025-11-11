<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

trait HasTwoFactorAuth
{
    /**
     * Generate a 6-digit 2FA code
     */
    public function generateTwoFactorCode(): string
    {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->two_factor_code = $code;
        $this->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $this->save();
        
        return $code;
    }
    
    /**
     * Send 2FA code via email
     */
    public function sendTwoFactorCode(): void
    {
        $code = $this->generateTwoFactorCode();
        
        // Generate verification URL with code
        $verificationUrl = route('auth.two-factor.verify-link', ['code' => $code]);
        
        Mail::to($this->email)->send(
            new TwoFactorCodeMail($code, $this->name, 10, $verificationUrl)
        );
    }
    
    /**
     * Verify 2FA code
     */
    public function verifyTwoFactorCode(string $code): bool
    {
        if (!$this->two_factor_code || !$this->two_factor_expires_at) {
            return false;
        }
        
        if (Carbon::now()->isAfter($this->two_factor_expires_at)) {
            $this->clearTwoFactorCode();
            return false;
        }
        
        if ($this->two_factor_code === $code) {
            $this->clearTwoFactorCode();
            return true;
        }
        
        return false;
    }
    
    /**
     * Clear 2FA code
     */
    public function clearTwoFactorCode(): void
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
    
    /**
     * Check if 2FA is enabled
     */
    public function hasTwoFactorEnabled(): bool
    {
        return (bool) $this->two_factor_enabled;
    }
    
    /**
     * Enable 2FA
     */
    public function enableTwoFactor(string $method = 'email'): void
    {
        $this->two_factor_enabled = true;
        $this->two_factor_method = $method;
        $this->save();
    }
    
    /**
     * Disable 2FA
     */
    public function disableTwoFactor(): void
    {
        $this->two_factor_enabled = false;
        $this->two_factor_method = null;
        $this->two_factor_phone = null;
        $this->save();
        $this->clearTwoFactorCode();
    }
}