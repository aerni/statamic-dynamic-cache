<?php

namespace Aerni\DynamicCache\Listeners;

use Statamic\Events\EntryDeleted;
use Illuminate\Support\Facades\Cache;
use Aerni\DynamicCache\Facades\Config;

class EntryDeletedListener
{
    public function handle(EntryDeleted $event): void
    {
        Config::remove($event->entry->url())->save();
        Cache::forget($event->entry->id());
    }
}
