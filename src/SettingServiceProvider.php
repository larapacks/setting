<?php

namespace Larapacks\Setting;

use Illuminate\Support\ServiceProvider;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Apply the 'settings' configuration.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $publish = [__DIR__.'/../config/config.php' => config_path('setting.php')];

            if (! class_exists('CreateSettingsTable')) {
                $publish[ __DIR__ . '/../database/migrations/create_settings_table.php.stub'] = database_path('migrations/' . date('Y_m_d_His', time()) . '_create_settings_table.php');
            }

            $this->publishes($publish);
        }

        $this->mergeConfigFrom( __DIR__.'/../config/config.php', 'setting');
    }

    /**
     * Register the settings instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SettingContract::class, function () {
            $model = config('setting.model');

            return new Setting(new $model());
        });
    }
}
