<?php

namespace Aerni\DynamicCache\Actions;

use Illuminate\Support\Collection;
use Aerni\DynamicCache\Facades\Data;
use Aerni\DynamicCache\Facades\Config;
use Aerni\DynamicCache\Facades\Storage;
use Aerni\DynamicCache\Contracts\Action;

class SaveExcludeConfig implements Action
{
    public function execute(): void
    {
        Config::set($this->newConfig())
            ->save();

        Storage::put(Data::getExcludeConfig()->toArray());
    }

    private function newConfig(): Collection
    {
        return Data::getExcludeConfig()
            ->merge($this->manualConfigChanges());
    }

    private function manualConfigChanges(): Collection
    {
        $storedConfig = Storage::get();
        $config = Config::get();

        return $config->diff($storedConfig);
    }
}
