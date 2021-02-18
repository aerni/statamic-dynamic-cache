<?php

namespace Aerni\DynamicCache\Commands;

use Aerni\DynamicCache\Actions\SaveStaticCachingConfig;
use Illuminate\Console\Command;
use Statamic\Console\RunsInPlease;

class Update extends Command
{
    use RunsInPlease;

    protected $signature = 'dynamic-cache:update';
    protected $description = 'Update the static cache config';

    public function handle(SaveStaticCachingConfig $saveStaticCachingConfig): void
    {
        $saveStaticCachingConfig->execute();

        $this->info('The static caching config has been updated successfully!');
    }
}
