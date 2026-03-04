<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::where('key', '!=', 'logo')->orderBy('key')->get();
        $logoUrl = null;
        $logoSetting = Setting::where('key', 'logo')->first();
        if ($logoSetting?->value) {
            $logoUrl = Storage::disk('public')->exists($logoSetting->value)
                ? asset('storage/' . $logoSetting->value)
                : null;
        }

        return view('admin.settings', compact('settings', 'logoUrl'));
    }

    /**
     * Store or update settings (bulk).
     */
    public function store(Request $request)
    {
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:png,jpg,jpeg,svg|max:2048',
            ]);

            // Delete old logo if exists
            $oldLogo = Setting::where('key', 'logo')->first();
            if ($oldLogo?->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }

            $path = $request->file('logo')->store('settings/logos', 'public');
            Setting::set('logo', $path);
        }

        // Handle key-value settings from the form
        $keys = $request->input('keys', []);
        $values = $request->input('values', []);

        foreach ($keys as $index => $key) {
            $key = trim($key);
            if ($key !== '') {
                Setting::set($key, $values[$index] ?? '');
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings saved successfully.');
    }

    /**
     * Add a new setting row (AJAX or via form).
     */
    public function addSetting(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
        ]);

        Setting::set($request->key, $request->value ?? '');

        return redirect()->route('admin.settings.index')->with('success', 'Setting added successfully.');
    }

    /**
     * Remove a setting.
     */
    public function destroy(Setting $setting)
    {
        if ($setting->key === 'logo' && $setting->value) {
            Storage::disk('public')->delete($setting->value);
        }

        $setting->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Setting removed.');
    }
}
