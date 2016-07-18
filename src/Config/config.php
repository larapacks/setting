<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure the settings model.
    |
    */

    'model' => Larapacks\Setting\Models\Setting::class,

    /*
    |--------------------------------------------------------------------------
    | Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to enable / disable encryption.
    |
    | If enabled, **all** setting values are encrypted using
    | your configured applications cipher and key.
    |
    | Encryption cannot be disabled after use, otherwise you will receive
    | arbitrary encrypted strings that won't resemble the true value.
    |
    */

    'encryption' => true,

];
