<?php

namespace Aerni\DynamicCache\Contracts;

use Illuminate\Support\Collection;

interface Config
{
    public function get(): Collection;

    public function set(Collection $config): self;

    public function save(): void;
}
