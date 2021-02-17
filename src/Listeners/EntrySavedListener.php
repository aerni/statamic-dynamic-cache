<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveStaticCachingConfig;
use Statamic\Events\EntrySaved;

class EntrySavedListener
{
    private $saveStaticCachingConfig;

    public function __construct(SaveStaticCachingConfig $saveStaticCachingConfig)
    {
        $this->saveStaticCachingConfig = $saveStaticCachingConfig;
    }

    public function handle(EntrySaved $event): void
    {
        $this->saveStaticCachingConfig->execute();
    }
}
