<?php

namespace Larapacks\Setting;

use Illuminate\Support\ServiceProvider;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../migrations/' => database_path('migrations'),
                __DIR__.'/../config/config.php' => config_path('ldap.php'),
            ]);
        }

        $this->mergeConfigFrom( __DIR__.'/../config/config.php', 'setting');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton(SettingContract::class, function () {
            $model = config('setting.model');

            return new Setting(new $model());
        });
    }
}
