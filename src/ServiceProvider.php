<?php

namespace Aerni\DynamicCache;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        \Statamic\Events\EntrySaved::class => [
            \Aerni\DynamicCache\Listeners\EntrySavedListener::class,
        ],
        \Statamic\Events\EntryDeleted::class => [
            \Aerni\DynamicCache\Listeners\EntryDeletedListener::class,
        ],
    ];
}
