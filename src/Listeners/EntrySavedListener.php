<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Facades\Data;
use Aerni\DynamicCache\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Statamic\Events\EntrySaved;

class EntrySavedListener
{
    public function handle(EntrySaved $event): void
    {
        $id = $event->entry->id();
        $url = $event->entry->url();
        $data = $event->entry->data();

        if (Data::shouldExcludeEntryFromStaticCache($data)) {
            $this->addUrlToExcludeConfig($id, $url);
        } else {
            $this->removeUrlFromExcludeConfig($id, $url);
        }
    }

    private function addUrlToExcludeConfig(string $id, string $url): void
    {
        if (Config::contains($url)) {
            return;
        }

        Config::remove(Cache::get($id))
            ->add($url)
            ->save();

        Cache::put($id, $url);
    }

    private function removeUrlFromExcludeConfig(string $id, string $url): void
    {
        if (! Config::contains($url)) {
            return;
        }

        Config::remove($url)->save();
        Cache::forget($id);
    }
}
