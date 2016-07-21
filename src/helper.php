<?php

if (!function_exists('setting')) {
    /**
     * Returns the underlying Setting instance.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return \Larapacks\Setting\Setting
     */
    function setting($key = null, $default = null)
    {
        $setting = \Larapacks\Setting\Facades\Setting::getFacadeRoot();

        if (is_null($key)) {
            return $setting;
        }

        return $setting->get($key, $default);
    }
}
