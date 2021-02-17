<?php

namespace Aerni\DynamicCache\Contracts;

use Illuminate\Support\Collection;

interface Config
{
    public function getExclude(): Collection;

    public function getInvalidationRules(): Collection;

    public function setExclude(Collection $config): self;

    public function setInvalidationRules(Collection $config): self;

    public function save(): void;
}
