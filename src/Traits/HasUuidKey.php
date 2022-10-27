<?php

namespace MagedAhmad\Insular\Traits;

use Illuminate\Support\Str;

trait HasUuidKey
{
    protected static function boot()
    {
        parent::boot();

        static::creating(callback: static function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
