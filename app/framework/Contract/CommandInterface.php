<?php

declare(strict_types = 1);

namespace Framework\Contract;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface CommandInterface
{
    public function execute(): bool;
}
