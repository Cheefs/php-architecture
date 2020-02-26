<?php

declare(strict_types = 1);

namespace Framework\Command;

use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterConfigCommand
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @return ContainerBuilder
     */
    public function getContainerBuilder(): ContainerBuilder
    {
        return $this->containerBuilder;
    }

    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function setContainerBuilder(ContainerBuilder $containerBuilder): void
    {
        $this->containerBuilder = $containerBuilder;
    }

    public function __construct( ContainerBuilder $containerBuilder )
    {
        $this->containerBuilder = $containerBuilder;
    }
}
