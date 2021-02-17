<?php

namespace Aerni\DynamicCache\Contracts;

interface Storage
{
    public static function getExclude(): array;

    public static function getInvalidationRules(): array;

    public static function putExclude(array $config): void;

    public static function putInvalidationRules(array $config): void;
}
