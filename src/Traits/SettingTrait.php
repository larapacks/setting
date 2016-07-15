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
        $this->attributes['value'] = serialize($value);
    }

    /**
     * An accessor for unserializing the value when retrieved.
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        return unserialize($this->attributes['value']);
    }
}
