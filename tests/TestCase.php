<?php

namespace Larapacks\Setting\Tests;

use CreateSettingsTable;
use Larapacks\Setting\SettingServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        include_once __DIR__.'/../database/migrations/create_settings_table.php.stub';

        (new CreateSettingsTable())->up();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [SettingServiceProvider::class];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.cipher', 'AES-256-CBC');
        $app['config']->set('app.key', 'SomeRandomStringWith32Characters');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
