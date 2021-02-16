<?php

namespace Aerni\DynamicCache\Contracts;

interface Storage
{
    public static function get(): array;

    public static function put(array $config): void;
}
