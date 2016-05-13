<?php

namespace Larapacks\Setting\Tests;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Setting\Facades\Setting;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class SettingTest extends TestCase
{
    public function test_contract_resolution()
    {
        $this->assertInstanceOf(SettingContract::class, app(SettingContract::class));
    }

    public function test_set()
    {
        Setting::set('key', 'value');

        $this->seeInDatabase('settings', [
            'key'   => 'key',
            'value' => 'value',
        ]);
    }

    public function test_with_description()
    {
        Setting::set('key', 'value', 'description');

        $this->seeInDatabase('settings', [
            'key'   => 'key',
            'value' => 'value',
            'description' => 'description',
        ]);
    }

    public function test_set_update()
    {
        Setting::set('key', 'value');

        Setting::set('key', 'updated');

        $this->seeInDatabase('settings', [
            'key'   => 'key',
            'value' => 'updated',
        ]);

        $this->dontSeeInDatabase('settings', [
            'key'   => 'key',
            'value' => 'value',
        ]);
    }

    public function test_get()
    {
        $this->test_set();

        $setting = Setting::get('key');

        $this->assertInstanceOf(Model::class, $setting);
        $this->assertEquals('value', $setting->value);
        $this->assertEquals('key', $setting->key);
    }
}
