<?php

namespace Larapacks\Setting;

use Closure;
use Illuminate\Support\Facades\Cache;
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
            collect($keys)->each(function ($value, $key) {
                $this->set($key, $value);
            });

            return;
        }

        $model = $this->find($keys) ?: $this->model->newInstance();

        $model->key = $model->key ?? $keys;
        $model->value = $value;

        $model->save();

        $this->cache($keys, function () use ($model) {
            return $model;
        }, $forget = true);
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
        return $this->cache($key, function () use ($key) {
            return $this->model()->where(['key' => $key])->first();
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
     * Caches and returns the settings value.
     *
     * @param mixed   $key
     * @param Closure $value
     * @param bool    $forget
     *
     * @return mixed
     */
    protected function cache($key, Closure $value, $forget = false)
    {
        $key = "setting.{$key}";

        if ($forget) {
            Cache::forget($key);
        }

        return Cache::remember($key, config('setting.cache', 60), $value);
    }
}
