<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->shareAppLogo();
    }

    /**
     * Share the app logo URL globally for use in all views.
     */
    protected function shareAppLogo(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                View::share('appLogoUrl', null);
                return;
            }
            $logoPath = Setting::get('logo');
            $appLogoUrl = $logoPath && Storage::disk('public')->exists($logoPath)
                ? asset('storage/' . $logoPath)
                : null;
        } catch (\Throwable $e) {
            $appLogoUrl = null;
        }
        View::share('appLogoUrl', $appLogoUrl);
    }
}
