<?php

namespace Aerni\DynamicCache;

use Illuminate\Support\Collection;

class Data
{
    // TODO: Support multi-sites
    // TODO: If replicator is deactivated, it should be ignored
    // TODO: If the blueprint doesn't contain the variable anymore, also delete it from the data
    // TODO: If you change a slug or move a page, also change the config
    // TODO: Merge new config with original but respect manual changes that have been made to the original config

    public function shouldExcludeEntryFromStaticCache(Collection $data): bool
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
