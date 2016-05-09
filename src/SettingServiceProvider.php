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
        // The configuration path.
        $config = __DIR__.'/Config/config.php';

        // The migrations path.
        $migrations = __DIR__.'/Migrations/';

        // The setting tag.
        $tag = 'setting';

        // Set the configuration and migrations to publishable.
        $this->publishes([
            $migrations => database_path('migrations'),
            $config     => config_path('setting.php'),
        ], $tag);

        // Merge the configuration.
        $this->mergeConfigFrom($config, 'setting');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->bind(SettingContract::class, function () {
            $model = config('setting.model');

            return new Setting(new $model);
        });
    }
}
