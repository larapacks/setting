<?php

namespace Larapacks\Setting;

use Illuminate\Database\Eloquent\Model;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class Setting implements SettingContract
{
    /**
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
    public function set($key, $value = null, $description = null)
    {
        $model = ($this->get($key) ?: $this->model->newInstance());

        $model->key = $key;
        $model->value = $value;
        $model->description = $description;

        return $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->model->where(['key' => $key])->first();
    }

    /**
     * Returns the settings model.
     *
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }
}
