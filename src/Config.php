<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Config as ConfigContract;
use Illuminate\Support\Collection;
use Stillat\Proteus\Support\Facades\ConfigWriter;

class Config implements ConfigContract
{
    private $exclude;
    private $invalidationRules;

    public function getExclude(): Collection
    {
        return $this->exclude ?? collect(ConfigWriter::getConfigItem('statamic.static_caching.exclude'));
    }

    public function getInvalidationRules(): Collection
    {
        return $this->invalidationRules ?? collect(ConfigWriter::getConfigItem('statamic.static_caching.invalidation.rules'));
    }

    public function setExclude(Collection $config): self
    {
        $this->exclude = $config;

        return $this;
    }

    public function setInvalidationRules(Collection $config): self
    {
        $this->invalidationRules = $config;

        return $this;
    }

    private function toExcludeArray(): array
    {
        return $this->exclude->all();
    }

    private function toInvalidationRulesArray(): array
    {
        return $this->invalidationRules->all();
    }

    public function save(): void
    {
        ConfigWriter::edit('statamic.static_caching')
            ->replace('exclude', $this->toExcludeArray())
            ->replace('invalidation.rules', $this->toInvalidationRulesArray())
            ->save();
    }
}
