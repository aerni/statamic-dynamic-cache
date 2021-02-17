<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Storage as StorageContract;
use Statamic\Facades\File;
use Statamic\Facades\YAML;

class Storage implements StorageContract
{
    public static function getExclude(): array
    {
        return YAML::parse(File::get(Self::excludePath()));
    }

    public static function getInvalidationRules(): array
    {
        return YAML::parse(File::get(Self::invalidationRulesPath()));
    }

    public static function putExclude(array $config): void
    {
        File::put(Self::excludePath(), YAML::dump($config));
    }

    public static function putInvalidationRules(array $config): void
    {
        File::put(Self::invalidationRulesPath(), YAML::dump($config));
    }

    private static function excludePath(): string
    {
        return storage_path('statamic/addons/dynamic-cache/exclude_cache.yaml');
    }

    private static function invalidationRulesPath(): string
    {
        return storage_path('statamic/addons/dynamic-cache/invalidation_rules_cache.yaml');
    }
}
