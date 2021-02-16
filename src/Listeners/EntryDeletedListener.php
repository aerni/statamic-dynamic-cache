<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveExcludeConfig;
use Statamic\Events\EntryDeleted;

class EntryDeletedListener
{
    private $saveExcludeConfig;

    public function __construct(SaveExcludeConfig $saveExcludeConfig)
    {
        $this->saveExcludeConfig = $saveExcludeConfig;
    }

    public function handle(EntryDeleted $event): void
    {
        $this->saveExcludeConfig->execute();
    }
}