<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Storage as StorageContract;
use Statamic\Facades\File;
use Statamic\Facades\YAML;

class Storage implements StorageContract
{
    public static function get(): array
    {
        return YAML::parse(File::get(Self::filepath()));
    }

    public static function put(array $config): void
    {
        File::put(Self::filepath(), YAML::dump($config));
    }

    private static function filepath(): string
    {
        return storage_path("statamic/addons/dynamic-cache/exclude_cache.yaml");
    }
}
