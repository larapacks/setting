<?php

namespace Larapacks\Setting\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

interface Setting
{
    /**
     * Constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model);

    /**
     * Sets the value for the specified key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function set($key, $value = null);

    /**
     * Returns the retrieved setting.
     *
     * @param string $key
     *
     * @return Model|null
     */
    public function get($key);

    /**
     * Returns the settings model.
     *
     * @return Model
     */
    public function model();

    /**
     * Sets the current user for setting and retrieving settings.
     *
     * @param Authenticatable $user
     *
     * @return $this
     */
    public function user(Authenticatable $user);
}
