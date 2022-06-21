<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveStaticCachingConfig;
use Statamic\Events\EntryDeleted;

class EntryDeletedListener
{
    private $saveStaticCachingConfig;

    public function __construct(SaveStaticCachingConfig $saveStaticCachingConfig)
    {
        $this->saveStaticCachingConfig = $saveStaticCachingConfig;
    }

    public function handle(EntryDeleted $event): void
    {
        $this->saveStaticCachingConfig->execute();
    }
}
