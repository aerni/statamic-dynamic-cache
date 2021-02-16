<?php

namespace Aerni\DynamicCache\Facades;

use Illuminate\Support\Facades\Facade;

class Storage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aerni\DynamicCache\Storage::class;
    }
}
