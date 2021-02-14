<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Facades\Data;
use Illuminate\Support\Facades\Config;
use Statamic\Statamic;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
        parent::boot();

        Statamic::booted(function () {
            Config::set('statamic.static_caching.exclude', Data::urlsToExclude());
        });
    }
}
