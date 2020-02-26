<?php

declare(strict_types=1);

namespace Command\UseCase;

use Framework\Command\RegisterConfigCommand;
use Framework\Command\RegisterRoutesCommand;
use Framework\Contract\CommandInterface;

class RegisterRoutesHandler implements CommandInterface
{
    /**
     * @var RegisterRoutesCommand
     */
    private $command;

    /**
     * @param RegisterRoutesCommand $command
     */
    public function __construct( RegisterRoutesCommand $command )
    {
        $this->command = $command;
    }

    public function execute(): bool
    {
        $routesCollection = [];
        $containerBuilder = $this->command->getContainerBuilder();
        $containerBuilder->set('route_collection', $routesCollection );

        $this->command->setRouteCollection( $routesCollection );
        return true;
    }
}