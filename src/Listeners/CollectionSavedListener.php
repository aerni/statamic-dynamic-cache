<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveExcludeConfig;
use Statamic\Events\CollectionSaved;

class CollectionSavedListener
{
    private $saveExcludeConfig;

    public function __construct(SaveExcludeConfig $saveExcludeConfig)
    {
        $this->saveExcludeConfig = $saveExcludeConfig;
    }

    public function handle(CollectionSaved $event): void
    {
        $this->saveExcludeConfig->execute();
    }
}
