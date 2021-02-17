<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveStaticCachingConfig;
use Statamic\Events\CollectionSaved;

class CollectionSavedListener
{
    private $saveStaticCachingConfig;

    public function __construct(SaveStaticCachingConfig $saveStaticCachingConfig)
    {
        $this->saveStaticCachingConfig = $saveStaticCachingConfig;
    }

    public function handle(CollectionSaved $event): void
    {
        $this->saveStaticCachingConfig->execute();
    }
}
