<?php

namespace Aerni\DynamicCache\Actions;

use Aerni\DynamicCache\Helpers;
use Illuminate\Support\Collection;
use Aerni\DynamicCache\Facades\Data;
use Aerni\DynamicCache\Facades\Config;
use Aerni\DynamicCache\Facades\Storage;
use Aerni\DynamicCache\Contracts\Action;
use Aerni\DynamicCache\Events\DynamicCacheSaved;

class SaveStaticCachingConfig implements Action
{
    public function execute(): void
    {
        $newConfig = Config::setExclude($this->newExclude());

        if (! Config::getInvalidationRules()->contains('all')) {
            $newConfig->setInvalidationRules($this->newInvalidationRules());
        }

        $newConfig->save();

        Storage::putExclude(Data::getExclude()->toArray());
        Storage::putInvalidationRules(Data::getInvalidationRules()->toArray());

        DynamicCacheSaved::dispatch($newConfig);
    }

    private function newExclude(): Collection
    {
        return Data::getExclude()
            ->merge($this->manualExcludeChanges())
            ->sort();
    }

    private function newInvalidationRules(): Collection
    {
        $merged = Data::getInvalidationRules()
            ->mergeRecursive($this->manualInvalidationRulesChanges())
            ->toArray();

        return collect(Helpers::sortRecursive($merged));
    }

    private function manualExcludeChanges(): Collection
    {
        $currentConfig = Config::getExclude();
        $storedConfig = Storage::getExclude();

        return $currentConfig->diff($storedConfig);
    }

    private function manualInvalidationRulesChanges(): array
    {
        $currentConfig = Config::getInvalidationRules()->toArray();
        $storedConfig = Storage::getInvalidationRules();

        return Helpers::diffAssocRecursive($currentConfig, $storedConfig);
    }
}
