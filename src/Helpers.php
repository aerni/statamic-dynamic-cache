<?php

namespace Aerni\DynamicCache;

use Illuminate\Support\Arr;

class Helpers
{
    public static function sortRecursive(array $array): array
    {
        return collect($array)->map(function ($item) {
            if (is_array($item) && Arr::isAssoc($item)) {
                $sorted = collect($item)->sortKeys()->toArray();
                return Self::sortRecursive($sorted);
            }

            if (is_array($item) && ! Arr::isAssoc($item)) {
                $sorted = collect($item)->sort()->values()->toArray();
                return Self::sortRecursive($sorted);
            }

            return $item;
        })->toArray();
    }

    public static function diffAssocRecursive(array $array1, array $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (! array_key_exists($key, $array2)) {
                    $difference[$key] = $value;
                } elseif (! is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $multidimensionalDiff = Self::diffAssocRecursive($value, $array2[$key]);
                    if (count($multidimensionalDiff) > 0) {
                        $difference[$key] = $multidimensionalDiff;
                    }
                }
            } else {
                // My solution that works with numeric array keys.
                if (! in_array($value, $array2)) {
                    $difference[] = $value;
                }
                // From original author. This doesn't work with numeric array keys, only with associative arrays.
                // if (! array_key_exists($key, $array2) || $array2[$key] !== $value) {
                //     $difference[$key] = $value;
                // }
            }
        }

        return $difference;
    }
}
