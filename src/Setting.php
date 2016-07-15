<?php

namespace Larapacks\Setting;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class Setting implements SettingContract
{
    /**
     * The Setting model.
     *
     * @var Model
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->find($key) instanceof Model;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $model = $this->find($key);

        return ($model ? $model->value : $default);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->model->all()->pluck('value', 'key');
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value = null)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException("Key must be a string.");
        }

        $model = ($this->find($key) ?: $this->model->newInstance());

        $model->key = $key;
        $model->value = $value;

        return $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function find($key)
    {
        return $this->model()->whereKey($key)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function model()
    {
        return $this->model;
    }
}
