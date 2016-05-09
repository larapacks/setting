<?php

namespace Larapacks\Setting;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Larapacks\Setting\Contracts\Setting as SettingContract;

class Setting implements SettingContract
{
    /**
     * The user for the specified settings.
     *
     * @var null|Authenticatable
     */
    protected $user = null;

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
    public function set($key, $value = null)
    {
        $userId = $this->getUserIdentifier();

        // Try to find the existing setting.
        $model = $this->model->where([
            'key'       => $key,
            'user_id'   => $userId,
        ])->first();

        // Setting isn't found, retrieve new fresh instance.
        if (! $model instanceof Model) $model = $this->model->newInstance();

        $model->key = $key;
        $model->user_id = $userId;
        $model->value = $value;

        $saved = $model->save();

        // Clear current user.
        $this->user();

        return $saved;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $model = $this->model->where([
            'key'       => $key,
            'user_id'   => $this->getUserIdentifier(),
        ])->first();

        // Clear current user.
        $this->user();

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function user(Authenticatable $user = null)
    {
        $this->user = $user;

        return $this;
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

    /**
     * Returns the current users identifier.
     *
     * @return int|null
     */
    protected function getUserIdentifier()
    {
        return (is_null($this->user) ? null : $this->user->getAuthIdentifier());
    }
}
