<?php

namespace MagedAhmad\Insular;

use Illuminate\Support\Facades\Facade;

class InsularFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'insular';
    }
}
