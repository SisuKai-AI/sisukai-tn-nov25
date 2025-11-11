# Two-Factor Authentication (2FA) Implementation

## Overview

This document describes the two-factor authentication (2FA) implementation for the SisuKai platform. 2FA is an optional security feature that can be activated per learner and/or admin user to add an extra layer of protection to their accounts.

## Implementation Status

### ✅ Completed (Phase 1)

1. **Database Schema**
   - Added 2FA fields to `learners` and `users` tables
   - Fields: `two_factor_enabled`, `two_factor_method`, `two_factor_code`, `two_factor_expires_at`, `two_factor_phone`

2. **HasTwoFactorAuth Trait**
   - Reusable trait for both Learner and User models
   - Comprehensive methods for 2FA management

3. **Email Notification**
   - TwoFactorCodeMail class
   - Professional email template with 6-digit code display
   - 10-minute expiration notice

4. **Model Integration**
   - Trait added to Learner and User models
   - Fillable arrays updated

### 🔄 In Progress (Phase 2)

1. **Profile Page UI**
   - 2FA activation toggle in learner profile settings
   - 2FA activation toggle in admin profile settings
   - Method selection (Email/SMS placeholder)

2. **Login Flow Integration**
   - Detect 2FA-enabled accounts during login
   - Send 2FA code after password verification
   - 2FA code verification page
   - Resend code functionality

3. **Admin Controllers**
   - Toggle 2FA endpoint
   - Verify 2FA code endpoint

### 📋 TODO (Phase 3)

1. **SMS Integration**
   - Integrate SMS provider (Twilio, AWS SNS, etc.)
   - Implement SMS sending in HasTwoFactorAuth trait
   - Add phone number validation

2. **Backup Codes**
   - Generate 10 single-use backup codes
   - Store hashed backup codes
   - UI for viewing/regenerating codes

3. **Recovery Options**
   - Account recovery if 2FA device lost
   - Admin override for locked accounts

## Database Schema

### Learners Table
```sql
ALTER TABLE learners ADD COLUMN two_factor_enabled BOOLEAN DEFAULT FALSE;
ALTER TABLE learners ADD COLUMN two_factor_method VARCHAR(255) NULL;
ALTER TABLE learners ADD COLUMN two_factor_code VARCHAR(6) NULL;
ALTER TABLE learners ADD COLUMN two_factor_expires_at TIMESTAMP NULL;
ALTER TABLE learners ADD COLUMN two_factor_phone VARCHAR(255) NULL;
```

### Users Table (Admins)
```sql
ALTER TABLE users ADD COLUMN two_factor_enabled BOOLEAN DEFAULT FALSE;
ALTER TABLE users ADD COLUMN two_factor_method VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN two_factor_code VARCHAR(6) NULL;
ALTER TABLE users ADD COLUMN two_factor_expires_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN two_factor_phone VARCHAR(255) NULL;
```

## HasTwoFactorAuth Trait

Located at: `app/Traits/HasTwoFactorAuth.php`

### Methods

#### `generateTwoFactorCode(): string`
- Generates a random 6-digit code
- Sets expiration to 10 minutes from now
- Saves code to database
- Returns the generated code

#### `sendTwoFactorCode(): void`
- Calls `generateTwoFactorCode()`
- Sends email with code using `TwoFactorCodeMail`
- For MVP, only email is supported
- SMS placeholder for future implementation

#### `verifyTwoFactorCode(string $code): bool`
- Checks if code exists and hasn't expired
- Compares provided code with stored code
- Clears code after successful verification
- Returns true if valid, false otherwise

#### `clearTwoFactorCode(): void`
- Clears `two_factor_code` and `two_factor_expires_at`
- Called after successful verification or expiration

#### `hasTwoFactorEnabled(): bool`
- Returns true if 2FA is enabled for the user

#### `enableTwoFactor(string $method = 'email'): void`
- Enables 2FA for the user
- Sets the method ('email' or 'sms')
- Saves to database

#### `disableTwoFactor(): void`
- Disables 2FA for the user
- Clears method and any pending codes

## Email Template

Located at: `resources/views/emails/two-factor-code.blade.php`

### Features
- **Large, centered 6-digit code** in monospace font with letter-spacing
- **Dashed border** around code for visual emphasis
- **Expiration notice** ("This code is valid for 10 minutes")
- **Security warning** for unauthorized attempts
- **Professional branding** with SisuKai logo and colors
- **Responsive design** for mobile and desktop

### Variables
- `$code` - The 6-digit verification code
- `$userName` - The user's name for personalization
- `$expiresInMinutes` - Expiration time (default: 10)

## Usage Examples

### Enable 2FA for a Learner
```php
$learner = Learner::find($id);
$learner->enableTwoFactor('email');
```

### Send 2FA Code During Login
```php
if ($learner->hasTwoFactorEnabled()) {
    $learner->sendTwoFactorCode();
    // Redirect to 2FA verification page
    return redirect()->route('auth.two-factor');
}
```

### Verify 2FA Code
```php
$learner = Learner::find($id);
if ($learner->verifyTwoFactorCode($request->code)) {
    // Code is valid, complete login
    Auth::guard('learner')->login($learner);
    return redirect()->route('learner.dashboard');
} else {
    // Code is invalid or expired
    return back()->withErrors(['code' => 'Invalid or expired code']);
}
```

### Disable 2FA
```php
$learner = Learner::find($id);
$learner->disableTwoFactor();
```

## Security Considerations

1. **Code Expiration**
   - Codes expire after 10 minutes
   - Expired codes are automatically rejected
   - Codes are cleared after use

2. **Rate Limiting**
   - TODO: Implement rate limiting on code verification
   - Suggested: 5 attempts per 15 minutes

3. **Code Storage**
   - Codes are stored in plain text (6 digits, short-lived)
   - Consider hashing for additional security in production

4. **SMS Security**
   - SMS is less secure than TOTP apps
   - Vulnerable to SIM swapping attacks
   - Recommend TOTP as primary method in future

## Testing with Mailpit

1. **Enable 2FA for test user:**
   ```php
   $learner = Learner::where('email', 'learner@sisukai.com')->first();
   $learner->enableTwoFactor('email');
   ```

2. **Trigger 2FA code send:**
   ```php
   $learner->sendTwoFactorCode();
   ```

3. **View email in Mailpit:**
   - Open http://localhost:8025
   - Find "Your Two-Factor Authentication Code - SisuKai" email
   - Copy the 6-digit code

4. **Verify code:**
   ```php
   $isValid = $learner->verifyTwoFactorCode('123456');
   ```

## Future Enhancements

1. **TOTP (Time-based One-Time Password)**
   - Use Google Authenticator, Authy, etc.
   - More secure than SMS
   - No dependency on external services

2. **Backup Codes**
   - Generate 10 single-use backup codes
   - Allow account recovery if 2FA device lost

3. **Remember Device**
   - Option to skip 2FA on trusted devices for 30 days
   - Store device fingerprint in database

4. **Admin Dashboard**
   - View 2FA adoption rate
   - Force 2FA for specific user groups
   - Audit log of 2FA events

5. **WebAuthn / FIDO2**
   - Hardware security keys (YubiKey, etc.)
   - Biometric authentication
   - Most secure option

## Related Files

- `app/Traits/HasTwoFactorAuth.php` - 2FA trait
- `app/Mail/TwoFactorCodeMail.php` - Email notification class
- `app/Models/Learner.php` - Learner model with 2FA trait
- `app/Models/User.php` - User model with 2FA trait
- `resources/views/emails/two-factor-code.blade.php` - Email template
- `database/migrations/2025_11_09_213812_add_two_factor_fields_to_learners_table.php` - Learners migration
- `database/migrations/2025_11_09_213820_add_two_factor_fields_to_admin_users_table.php` - Users migration

## Commit History

- `fc617a7` - feat(auth): Implement two-factor authentication (2FA) infrastructure

---

**Status:** Phase 1 Complete ✅  
**Next Steps:** Implement profile page UI and login flow integration  
**Branch:** mvp-frontend
