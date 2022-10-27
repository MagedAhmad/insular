<?php

namespace MagedAhmad\Insular\Traits;

trait Snowflake
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function($model) {
            if (! $model->getKey()) {
               $key = resolve('snowflake')->id();
               $model->{$model->getKeyName()} = $key;
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }
}
