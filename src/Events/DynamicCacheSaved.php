<?php

namespace Aerni\DynamicCache\Events;

use Statamic\Events\Event;
use Aerni\DynamicCache\Config;
use Statamic\Contracts\Git\ProvidesCommitMessage;

class DynamicCacheSaved extends Event implements ProvidesCommitMessage
{
    public Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function commitMessage()
    {
        return __('Dynamic cache saved', [], config('statamic.git.locale'));
    }
}
