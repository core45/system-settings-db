<?php
namespace Core45\SystemSettingsDB;

use Core45\SystemSettingsDb\Http\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Schema;

class SystemSettingsDBServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('system_settings')) {
            config([
                'system-settings' => Cache::remember('system-settings', config('system-settings-db.cache-ttl') ?? 60, function () {
                    return SystemSetting::all(['key','value'])
                        ->keyBy('key')
                        ->transform(function ($setting) {
                            return $setting->value;
                        })
                        ->toArray();
                })
            ]);
        }




        // ============ Publish assets with php artisan vendor:publish ============
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/system-settings-db.php' => config_path('system-settings-db.php'),
                __DIR__ . '/../database/migrations/2023_06_10_185503_create_system_settings_table.php' =>
                    database_path('migrations/' . date('Y_m_d_His', time()) . '_create_system_settings_table.php'),
                    // More migration files here
            ], 'system-settings-db');
        }
    }
}
