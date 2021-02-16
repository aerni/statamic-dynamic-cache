<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Data as DataContract;
use Statamic\Entries\Entry;
use Illuminate\Support\Collection;

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
        $excludeFromStaticCache = $data->filter(function ($value, $key) {
            if (is_array($value)) {
                $this->shouldAddEntryUrlToExcludeConfig(collect($value));
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
