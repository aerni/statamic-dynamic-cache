<?php

namespace Aerni\DynamicCache;

use Aerni\DynamicCache\Contracts\Config as ConfigContract;
use Illuminate\Support\Collection;
use Stillat\Proteus\Support\Facades\ConfigWriter;

class Config implements ConfigContract
{
    private $config;

    public function get(): Collection
    {
        return $this->config ?? collect(ConfigWriter::getConfigItem('statamic.static_caching.exclude'));
    }

    public function set(Collection $config): self
    {
        $this->config = $config;

        return $this;
    }

    private function toConfigArray(): array
    {
        return $this->config->sort()->unique()->toArray();
    }

    public function save(): void
    {
        ConfigWriter::edit('statamic.static_caching')
            ->replace('exclude', $this->toConfigArray())
            ->save();
    }
}
