<?php

namespace Aerni\DynamicCache\Contracts;

interface Action
{
    public function execute(): void;
}
