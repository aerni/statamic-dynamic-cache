<?php

namespace Aerni\DynamicCache;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $listen = [
        \Statamic\Events\CollectionSaved::class => [
            \Aerni\DynamicCache\Listeners\CollectionSavedListener::class,
        ],
        \Statamic\Events\EntryDeleted::class => [
            \Aerni\DynamicCache\Listeners\EntryDeletedListener::class,
        ],
        \Statamic\Events\EntrySaved::class => [
            \Aerni\DynamicCache\Listeners\EntrySavedListener::class,
        ],
    ];
}
