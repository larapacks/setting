<?php

namespace Larapacks\Setting\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
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

    public function test_set_for_user()
    {
        $user = new User();

        $user->id = 1;

        Setting::user($user)->set('key', 'value');

        $this->seeInDatabase('settings', [
            'key'       => 'key',
            'value'     => 'value',
            'user_id'   => $user->id,
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

    public function test_set_update_for_user()
    {
        $user = new User();

        $user->id = 1;

        Setting::user($user)->set('key', 'user');

        Setting::set('key', 'value');

        $this->assertEquals('user', Setting::user($user)->get('key')->value);
        $this->assertEquals('value', Setting::get('key')->value);
        $this->assertEquals(2, Setting::model()->count());
    }

    public function test_get()
    {
        $this->test_set();

        $setting = Setting::get('key');

        $this->assertInstanceOf(Model::class, $setting);
        $this->assertEquals('value', $setting->value);
        $this->assertEquals('key', $setting->key);
    }

    public function test_get_for_user()
    {
        $user = new User();

        $user->id = 1;

        Setting::user($user)->set('key', 'value');

        $setting = Setting::user($user)->get('key');

        $this->assertInstanceOf(Model::class, $setting);
        $this->assertEquals('value', $setting->value);
        $this->assertEquals('key', $setting->key);
    }
}
