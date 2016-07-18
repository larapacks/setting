<?php

namespace Larapacks\Setting\Traits;

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

        $this->attributes['value'] = ($this->encryptionIsEnabled() ? encrypt($value) : $value);
    }

    /**
     * An accessor for unserializing the value when retrieved.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        $actual = $this->attributes['value'];

        $value = ($this->encryptionIsEnabled() ? decrypt($actual) : $actual);

        return unserialize($value);
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
