<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Data as DataContract;
use Illuminate\Support\Collection;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Statamic\Entries\Entry;

class Data implements DataContract
{
    public function getExclude(): Collection
    {
        return $this->entriesToExcludeFromStaticCache()->map(function ($entry) {
            return $entry->url();
        })
        ->sort();
    }

    public function getInvalidationRules(): Collection
    {
        $rules = $this->entriesToIncludeInInvalidationRules()->map(function ($entry) {
            return [
                'collection' => $entry->collectionHandle(),
                'url' => $entry->url()
            ];
        })->groupBy('collection')->map(function ($entry) {
            $urls = collect($entry)->map(function ($entry) {
                return $entry['url'];
            })
            ->sort()
            ->values()
            ->all();

            return ['urls' => $urls];
        })
        ->sortKeys();

        return $rules->isEmpty() ? $rules : collect(['collections' => $rules->all()]);
    }

    private function entriesToExcludeFromStaticCache(): Collection
    {
        return Entry::all()->map(function ($entry) {
            if ($this->shouldExcludeEntryFromStaticCache($entry->values())) {
                return $entry;
            }
        })
        ->filter();
    }

    private function entriesToIncludeInInvalidationRules(): Collection
    {
        return Entry::all()->map(function ($entry) {
            if (! $this->shouldExcludeEntryFromStaticCache($entry->values())) {
                return $entry;
            }
        })
        ->filter();
    }

    private function shouldExcludeEntryFromStaticCache(Collection $data): bool
    {
        $fieldHandle = config('dynamic-cache.handle', 'exclude_from_static_cache');

        $excludeFromStaticCache = Helpers::searchRecursive($data->toArray(), $fieldHandle, true);

        if (! $excludeFromStaticCache) {
            return false;
        }

        return true;
    }
}
