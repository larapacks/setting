<?php

namespace Larapacks\Setting\Tests;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class SettingTest extends TestCase
{
    public function test_contract_resolution()
    {
        $this->assertInstanceOf(SettingContract::class, app(SettingContract::class));
    }

    public function test_set()
    {
        setting()->set('key', 'value');

        /** @var Model $setting */
        $setting = setting()->model()->first();

        $this->assertEquals('key', $setting->key);
        $this->assertEquals('value', $setting->value);
    }

    public function test_is_encrypted()
    {
        $this->test_set();

        $setting = setting()->model()->first();

        $this->assertEquals('value', unserialize(decrypt($setting->getOriginal('value'))));
    }

    public function test_set_update()
    {
        setting()->set('key', 'value');

        setting()->set('key', 'updated');

        $this->seeInDatabase('settings', [
            'key'   => 'key',
        ]);
    }

    public function test_get()
    {
        $this->test_set();

        $this->assertEquals('value', setting()->get('key'));
    }

    public function test_get_default()
    {
        $this->assertEquals('default', setting()->get('non-existent-key', 'default'));
    }

    public function test_find()
    {
        $this->test_set();

        $this->assertInstanceOf(Model::class, setting()->find('key'));
        $this->assertNull(setting()->find('test'));
    }

    public function test_has()
    {
        $this->test_set();

        $this->assertTrue(setting()->has('key'));
    }

    public function test_all()
    {
        $settings = [
            'key.1' => 'value',
            'key.2' => 'value',
            'key.3' => 'value',
        ];

        setting()->set($settings);

        $this->assertEquals($settings, setting()->all()->toArray());
    }

    public function test_helper()
    {
        setting()->set('key', 'value');

        $this->assertEquals('value', setting()->get('key'));
    }

    public function test_inject()
    {
        $this->assertInstanceOf(SettingContract::class, app(SettingContract::class));
    }

    public function test_serialization()
    {
        setting()->set('boolean', true);

        $this->assertTrue(setting()->get('boolean'));
    }

    public function test_flip()
    {
        setting()->set('boolean', true);

        setting()->flip('boolean');

        $this->assertFalse(setting()->get('boolean'));

        setting()->flip('boolean');

        $this->assertTrue(setting()->get('boolean'));

        setting()->flip('new-key');

        $this->assertTrue(setting()->get('new-key'));
    }

    public function test_enable()
    {
        setting()->enable('new-key');

        $this->assertTrue(setting()->get('new-key'));
    }

    public function test_disable()
    {
        setting()->disable('new-key');

        $this->assertFalse(setting()->get('new-key'));
    }

    public function test_calling_on_model()
    {
        setting()->set('key', 'value');

        $this->assertTrue(setting()->first()->exists);
    }
}
