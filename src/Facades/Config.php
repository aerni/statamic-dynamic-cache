<?php

namespace Aerni\DynamicCache\Facades;

use Illuminate\Support\Facades\Facade;

class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aerni\DynamicCache\Config::class;
    }
}
