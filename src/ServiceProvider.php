<?php

namespace Aerni\DynamicCache;

use Statamic\Facades\Git;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $commands = [
        \Aerni\DynamicCache\Commands\Update::class,
    ];

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

    public function bootAddon()
    {
        Git::listen(\Aerni\DynamicCache\Events\DynamicCacheSaved::class);
    }
}
