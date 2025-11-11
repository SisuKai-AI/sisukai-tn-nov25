<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'trial_period_days' => Cache::get('trial_period_days', 7),
            'site_name' => Cache::get('site_name', 'SisuKai'),
            'support_email' => Cache::get('support_email', 'support@sisukai.com'),
        ];
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'trial_period_days' => 'required|integer|min:0|max:365',
            'site_name' => 'required|string|max:255',
            'support_email' => 'required|email|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
