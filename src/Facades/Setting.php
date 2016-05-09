<?php

namespace Larapacks\Setting\Facades;

use Illuminate\Support\Facades\Facade;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class Setting extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return SettingContract::class;
    }
}
