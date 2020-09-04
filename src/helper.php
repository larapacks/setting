<?php

use Larapacks\Setting\Contracts\Setting;

if (! function_exists('setting')) {
    /**
     * Returns the underlying Setting instance.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return \Larapacks\Setting\Setting|mixed
     */
    function setting($key = null, $default = null)
    {
        $setting = app(Setting::class);

        if (is_null($key)) {
            return $setting;
        }

        return $setting->get($key, $default);
    }
}
