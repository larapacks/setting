<?php

namespace Larapacks\Setting\Traits;

use Illuminate\Contracts\Encryption\DecryptException;

trait SettingTrait
{
    /**
     * A mutator for serializing a value before it's been set.
     *
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $value = serialize($value);

        $this->attributes['value'] = ($this->encryptionIsEnabled() ? $this->encrypt($value) : $value);
    }

    /**
     * An accessor for unserializing the value when retrieved.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        $actual = $this->attributes['value'];

        $value = ($this->encryptionIsEnabled() ? $this->decrypt($actual) : $actual);

        return unserialize($value);
    }

    /**
     * Encrypts the specified value.
     *
     * @param string $value
     *
     * @return string
     */
    protected function encrypt($value)
    {
        return encrypt($value);
    }

    /**
     * Decrypts the specified value.
     *
     * @param string $value
     *
     * @return string
     */
    protected function decrypt($value)
    {
        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            // If decryption fails, we'll just return the
            // plain value. It must not be encrypted.
            return $value;
        }
    }

    /**
     * Returns the setting encryption configuration option.
     *
     * @return bool
     */
    protected function encryptionIsEnabled()
    {
        return config('setting.encryption', true);
    }
}
