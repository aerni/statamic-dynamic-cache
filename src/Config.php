<?php

namespace Aerni\DynamicCache;

use Illuminate\Support\Collection;
use Stillat\Proteus\Support\Facades\ConfigWriter;

class Config
{
    private $config;

    public function __construct()
    {
        $this->config = $this->getOriginalConfig();
    }

    public function getOriginalConfig(): Collection
    {
        return collect(ConfigWriter::getConfigItem('statamic.static_caching.exclude'));
    }

    public function getConfigArray(): array
    {
        return $this->config->sort()->toArray();
    }

    public function contains(string $url): bool
    {
        return $this->config->contains($url);
    }

    public function add(string $url): self
    {
        $this->config = $this->config->merge($url);

        return $this;
    }

    public function remove(?string $url): self
    {
        $this->config = $this->config->diff($url);

        return $this;
    }

    public function save(): void
    {
        ConfigWriter::edit('statamic.static_caching')
            ->replace('exclude', $this->getConfigArray())
            ->save();
    }
}
