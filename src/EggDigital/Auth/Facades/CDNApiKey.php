<?php

namespace EggDigital\Auth\Facades;

use Illuminate\Support\Facades\Facade;

class CDNApiKey extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'auth\cdnapikey'; }

}