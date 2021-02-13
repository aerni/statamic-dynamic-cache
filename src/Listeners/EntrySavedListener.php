<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Facades\Data;
use Aerni\DynamicCache\Facades\Config;
use Statamic\Events\EntrySaved;

class EntrySavedListener
{
    public function handle(EntrySaved $event): void
    {
        $data = $event->entry->data();
        $url = $event->entry->url();

        if (Data::shouldExcludeEntryFromStaticCache($data)) {
            $this->addUrlToExcludeConfig($url);
        } else {
            $this->removeUrlFromExcludeConfig($url);
        }
    }

    private function addUrlToExcludeConfig(string $url): void
    {
        if (Config::contains($url)) {
            return;
        }

        Config::add($url)->save();
    }

    private function removeUrlFromExcludeConfig(string $url): void
    {
        if (! Config::contains($url)) {
            return;
        }

        Config::remove($url)->save();
    }
}
