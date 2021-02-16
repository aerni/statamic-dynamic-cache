<?php

namespace Aerni\DynamicCache\Contracts;

use Illuminate\Support\Collection;

interface Data
{
    public function getExcludeConfig(): Collection;
}
