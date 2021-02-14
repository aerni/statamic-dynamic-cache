<?php

namespace Aerni\DynamicCache;

use Statamic\Facades\Entry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

// TODO: Support multi-sites
// TODO: If replicator is deactivated, it should be ignored
// TODO: If the blueprint doesn't contain the variable anymore, also delete it from the data
// TODO: If you change a slug or move a page, also change the config
// TODO: Merge new config with original but respect manual changes that have been made to the original config
// TODO: Dynamically invalidate urls

class Data
{
    private $config;

    public function __construct()
    {
        $this->config = collect(Config::get('statamic.static_caching.exclude'));
    }

    public function urlsToExclude(): array
    {
        return Entry::all()->map(function ($entry) {
            if ($this->shouldExcludeEntryFromStaticCache($entry->data())) {
                return $entry->url();
            }
        })
        ->merge($this->config)
        ->unique()
        ->filter()
        ->toArray();
    }

    private function shouldExcludeEntryFromStaticCache(Collection $data): bool
    {
        $excludeFromStaticCache = $data->filter(function ($value, $key) {
            if (is_array($value)) {
                $this->shouldExcludeEntryFromStaticCache(collect($value));
            }

            if ($key === 'exclude_from_static_cache' && $value === true) {
                return true;
            }
        });

        if ($excludeFromStaticCache->isEmpty()) {
            return false;
        }

        return true;
    }
}
