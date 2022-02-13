<?php

namespace Aerni\DynamicCache\Events;

use Aerni\DynamicCache\Config;
use Statamic\Contracts\Git\ProvidesCommitMessage;
use Statamic\Events\Event;

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
