<?php

declare(strict_types = 1);


namespace Framework\Command;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterRoutesCommand
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @return ContainerBuilder
     */
    public function getContainerBuilder(): ContainerBuilder
    {
        return $this->containerBuilder;
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection(): RouteCollection
    {
        return $this->routeCollection;
    }

    /**
     * @param RouteCollection[] $routeCollection
     */
    public function setRouteCollection(array $routeCollection): void
    {
        $this->routeCollection = $routeCollection;
    }

    public function __construct( ContainerBuilder $containerBuilder )
    {
        $this->containerBuilder = $containerBuilder;
    }


}
