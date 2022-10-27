<?php

namespace MagedAhmad\Insular\Traits;

use Illuminate\Support\Str;

trait HasUuidToken
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(callback: static function ($model) {
            if (empty($model->uid)) {
                $model->uid = Str::uuid()->toString();
            }
        });
    }

}
