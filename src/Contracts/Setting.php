<?php

namespace Larapacks\Setting\Contracts;

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
     * Determines if a setting by the specified key exists.
     *
     * @param int|string $key
     *
     * @return mixed
     */
    public function has($key);

    /**
     * Retrieves a setting from the database.
     *
     * @param int|string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Sets the specified key to the specified value.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value = null);

    /**
     * Flips a boolean to its opposite value.
     *
     * This method exists for convenience.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function flip($key);

    /**
     * Sets the specified key to true.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function enable($key);

    /**
     * Sets the specified key to false.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function disable($key);

    /**
     * Delete the specified key.
     *
     * @param string $key
     *
     * @return void
     */
    public function delete($key);

    /**
     * Returns an array of all settings.
     *
     * @return array
     */
    public function all();

    /**
     * Finds a setting model by the specified key.
     *
     * @param int|string $key
     *
     * @return Model|null
     */
    public function find($key);

    /**
     * Returns the setting model.
     *
     * @return Model
     */
    public function model();
}
