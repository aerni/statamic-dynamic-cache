<?php

namespace Aerni\DynamicCache\Facades;

use Illuminate\Support\Facades\Facade;

class Data extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aerni\DynamicCache\Data::class;
    }
}
