<?php

namespace Larapacks\Setting\Tests;

use Larapacks\Setting\SettingServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('vendor:publish', ['--provider' => SettingServiceProvider::class]);

        $this->artisan('migrate');
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
