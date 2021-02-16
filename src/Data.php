<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Data as DataContract;
use Illuminate\Support\Collection;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use Statamic\Entries\Entry;

class Data implements DataContract
{
    public function getExcludeConfig(): Collection
    {
        return Entry::all()->map(function ($entry) {
            if ($this->shouldAddEntryUrlToExcludeConfig($entry->data())) {
                return $entry->url();
            }
        })
        ->filter();
    }

    private function shouldAddEntryUrlToExcludeConfig(Collection $data): bool
    {
        $excludeFromStaticCache = $this->recursiveSearch($data->toArray(), 'exclude_from_static_cache', true);

        if (! $excludeFromStaticCache) {
            return false;
        }

        return true;
    }

    private function recursiveSearch(array $haystack, $needleKey, $needleValue)
    {
        $iterator  = new RecursiveArrayIterator($haystack);
        $recursive = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($recursive as $key => $value) {
            if ($key === $needleKey && $value === $needleValue) {
                return $value;
            }
        }
    }
}
