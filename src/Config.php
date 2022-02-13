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

    public function save(): void
    {
        $exclude = $this->exclude->all();

        $invalidationRules = $this->invalidationRules
            ? $this->invalidationRules->all()
            : 'all';

        ConfigWriter::edit('statamic.static_caching')
            ->replace('exclude', $exclude)
            ->replace('invalidation.rules', $invalidationRules)
            ->save();
    }
}
