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
    public function excludeConfig(): array
    {
        return $this->entriesToExcludeFromStaticCache()->map(function ($entry) {
            return $entry->url();
        })
        ->merge(Config::get('statamic.static_caching.exclude'))
        ->unique()
        ->filter()
        ->toArray();
    }

    public function invalidationRules(): array
    {
        $rules = $this->entriesToIncludeInInvalidationRules()->map(function ($entry) {
            return [
                'collection' => $entry->collectionHandle(),
                'url' => $entry->url()
            ];
        })->groupBy('collection')->map(function ($entry) {
            $urls = collect($entry)->map(function ($entry) {
                return $entry['url'];
            })->all();

            return ['urls' => $urls];
        })->all();

        return array_merge_recursive(
            ['collections' => $rules],
            Config::get('statamic.static_caching.invalidation.rules')
        );
    }

    private function entriesToExcludeFromStaticCache(): Collection
    {
        return Entry::all()->map(function ($entry) {
            if ($this->shouldExcludeEntryFromStaticCache($entry->data())) {
                return $entry;
            }
        })->filter();
    }

    private function entriesToIncludeInInvalidationRules(): Collection
    {
        return Entry::all()->map(function ($entry) {
            if (! $this->shouldExcludeEntryFromStaticCache($entry->data())) {
                return $entry;
            }
        })->filter();
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
