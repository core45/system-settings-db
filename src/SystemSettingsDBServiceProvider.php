<?php

namespace Core45\SystemSettingsDb;

use Core45\SystemSettingsDb\Http\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

class SystemSettingsDBServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/system-settings-db.php', 'system-settings-db');
    }

    public function boot(): void
    {
        $this->loadSettingsIntoConfig();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/system-settings-db.php' => config_path('system-settings-db.php'),
            ], ['system-settings-db', 'system-settings-db-config']);

            $this->publishesMigrations([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], ['system-settings-db', 'system-settings-db-migrations']);
        }
    }

    /**
     * Load every stored setting into the `system-settings` config namespace.
     */
    protected function loadSettingsIntoConfig(): void
    {
        try {
            if (! Schema::hasTable('system_settings')) {
                return;
            }

            $settings = Cache::remember(
                'system-settings',
                (int) config('system-settings-db.cache-ttl', 60),
                fn (): array => SystemSetting::query()
                    ->pluck('value', 'key')
                    ->all()
            );

            config(['system-settings' => $settings]);
        } catch (Throwable) {
            // Database unavailable or not migrated yet - leave config untouched.
        }
    }
}
