<?php

namespace MagedAhmad\Insular\Traits;

use App;
use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function toArray(): array
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation(
                key: $field, locale: App::getLocale()
            );
        }

        return $attributes;
    }
}
