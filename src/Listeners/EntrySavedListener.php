<?php

namespace Aerni\DynamicCache\Listeners;

use Aerni\DynamicCache\Actions\SaveExcludeConfig;
use Statamic\Events\EntrySaved;

class EntrySavedListener
{
    private $saveExcludeConfig;

    public function __construct(SaveExcludeConfig $saveExcludeConfig)
    {
        $this->saveExcludeConfig = $saveExcludeConfig;
    }

    public function handle(EntrySaved $event): void
    {
        $this->saveExcludeConfig->execute();
    }
}
