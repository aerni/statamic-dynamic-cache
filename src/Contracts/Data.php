<?php

namespace Aerni\DynamicCache\Contracts;

use Illuminate\Support\Collection;

interface Data
{
    public function getExclude(): Collection;

    public function getInvalidationRules(): Collection;
}
