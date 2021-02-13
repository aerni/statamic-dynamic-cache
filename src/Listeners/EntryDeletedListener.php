<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Facades\Config;
use Statamic\Events\EntryDeleted;

class EntryDeletedListener
{
    public function handle(EntryDeleted $event): void
    {
        Config::remove($event->entry->url())->save();
    }
}
