<?php

namespace Larapacks\Setting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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

        return $model ? $model->value : $default;
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
    public function set($keys, $value = null)
    {
        if (is_array($keys)) {
            // If we've been given an array, we'll assume they're a
            // key value pair and create a setting for each.
            array_walk($keys, function ($value, $key) {
                $this->set($key, $value);
            });
        } else {
            $model = ($this->find($keys) ?: $this->model->newInstance());

            $model->key = $keys;
            $model->value = $value;

            $model->save();

            // Re-cache the model in case of changes.
            $this->cache($keys, function () use ($model) {
                return $model;
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function flip($key)
    {
        $this->set($key, !$this->get($key));
    }

    /**
     * {@inheritdoc}
     */
    public function enable($key)
    {
        $this->set($key, true);
    }

    /**
     * {@inheritdoc}
     */
    public function disable($key)
    {
        $this->set($key, false);
    }

    /**
     * {@inheritdoc}
     */
    public function find($key)
    {
        return $this->cache("setting.{$key}", function () use ($key) {
            return $this->model()->whereKey($key)->first();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Calls non-existent methods on the underlying Setting model instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->model, $method], $parameters);
    }

    /**
     * Caches the specified key / value.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function cache($key, $value)
    {
        return Cache::remember($key, config('setting.cache', 60), $value);
    }
}
