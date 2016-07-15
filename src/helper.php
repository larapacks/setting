<?php

if (! function_exists('setting')) {
    /**
     * Returns the underlying Setting instance.
     *
     * @return \Larapacks\Setting\Setting
     */
    function setting()
    {
        return \Larapacks\Setting\Facades\Setting::getFacadeRoot();
    }
}
