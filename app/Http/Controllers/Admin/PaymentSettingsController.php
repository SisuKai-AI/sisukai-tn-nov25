<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentProcessorSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PaymentSettingsController extends Controller
{
    /**
     * Display payment processor settings
     */
    public function index()
    {
        $settings = PaymentProcessorSetting::all()->keyBy('processor');
        $activeProcessor = Setting::getActivePaymentProcessor();
        
        return view('admin.payment-settings.index', compact('settings', 'activeProcessor'));
    }
    
    /**
     * Update payment processor settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'stripe_publishable_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'stripe_webhook_secret' => 'nullable|string',
            'stripe_is_active' => 'boolean',
            'paddle_vendor_id' => 'nullable|string',
            'paddle_auth_code' => 'nullable|string',
            'paddle_public_key' => 'nullable|string',
            'paddle_is_active' => 'boolean',
            'default_processor' => 'required|in:stripe,paddle',
        ]);
        
        // Update Stripe settings
        if ($request->filled('stripe_publishable_key')) {
            $this->updateOrCreateSetting('stripe', [
                'publishable_key' => $validated['stripe_publishable_key'],
                'secret_key' => $validated['stripe_secret_key'] ?? null,
                'webhook_secret' => $validated['stripe_webhook_secret'] ?? null,
                'is_active' => $validated['stripe_is_active'] ?? false,
            ]);
        }
        
        // Update Paddle settings
        if ($request->filled('paddle_vendor_id')) {
            $this->updateOrCreateSetting('paddle', [
                'vendor_id' => $validated['paddle_vendor_id'],
                'auth_code' => $validated['paddle_auth_code'] ?? null,
                'public_key' => $validated['paddle_public_key'] ?? null,
                'is_active' => $validated['paddle_is_active'] ?? false,
            ]);
        }
        
        // Update active payment processor in database
        Setting::set('active_payment_processor', $validated['default_processor']);
        
        // Also update .env file for backwards compatibility
        $this->updateEnvFile('DEFAULT_PAYMENT_PROCESSOR', $validated['default_processor']);
        
        return redirect()
            ->route('admin.payment-settings.index')
            ->with('success', 'Payment settings updated successfully');
    }
    
    /**
     * Test payment processor connection
     */
    public function test(Request $request, $processor)
    {
        $setting = PaymentProcessorSetting::where('processor', $processor)->first();
        
        if (!$setting || !$setting->is_active) {
            return response()->json([
                'success' => false,
                'message' => ucfirst($processor) . ' is not configured or inactive',
            ]);
        }
        
        try {
            if ($processor === 'stripe') {
                return $this->testStripeConnection($setting);
            } elseif ($processor === 'paddle') {
                return $this->testPaddleConnection($setting);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Test Stripe connection
     */
    private function testStripeConnection($setting)
    {
        \Stripe\Stripe::setApiKey($setting->getDecryptedSecretKey());
        
        try {
            $account = \Stripe\Account::retrieve();
            
            return response()->json([
                'success' => true,
                'message' => 'Stripe connection successful',
                'account' => [
                    'id' => $account->id,
                    'email' => $account->email,
                    'country' => $account->country,
                    'currency' => $account->default_currency,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe connection failed: ' . $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Test Paddle connection
     */
    private function testPaddleConnection($setting)
    {
        // Paddle API test implementation
        // This is a placeholder - actual implementation depends on Paddle SDK
        
        return response()->json([
            'success' => true,
            'message' => 'Paddle connection test not implemented yet',
        ]);
    }
    
    /**
     * Update or create payment processor setting
     */
    private function updateOrCreateSetting($processor, $data)
    {
        $setting = PaymentProcessorSetting::firstOrNew([
            'processor' => $processor,
        ]);
        
        $setting->id = $setting->id ?? \Illuminate\Support\Str::uuid();
        
        // Encrypt sensitive keys
        if (isset($data['secret_key'])) {
            $setting->secret_key = Crypt::encryptString($data['secret_key']);
        }
        if (isset($data['webhook_secret'])) {
            $setting->webhook_secret = Crypt::encryptString($data['webhook_secret']);
        }
        if (isset($data['auth_code'])) {
            $setting->auth_code = Crypt::encryptString($data['auth_code']);
        }
        
        // Store non-sensitive data
        $setting->publishable_key = $data['publishable_key'] ?? $data['vendor_id'] ?? null;
        $setting->public_key = $data['public_key'] ?? null;
        $setting->is_active = $data['is_active'] ?? false;
        
        $setting->save();
        
        return $setting;
    }
    
    /**
     * Update .env file
     */
    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        
        if (file_exists($path)) {
            $content = file_get_contents($path);
            
            if (str_contains($content, $key . '=')) {
                $content = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $content
                );
            } else {
                $content .= "\n{$key}={$value}\n";
            }
            
            file_put_contents($path, $content);
        }
    }
}
