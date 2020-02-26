<?php

declare(strict_types=1);

namespace Command\UseCase;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Framework\Command\RegisterConfigCommand;
use Framework\Contract\CommandInterface;

class RegisterConfigHandler implements CommandInterface
{
    /**
     * @var RegisterConfigCommand
     */
    private $command;

    /**
     * @return RegisterConfigCommand
     */
    public function getCommand(): RegisterConfigCommand
    {
        return $this->command;
    }

    /**
     * @param RegisterConfigCommand $command
     */
    public function __construct(RegisterConfigCommand $command)
    {
        $this->command = $command;
    }

    public function execute(): bool
    {
        $containerBuilder = $this->command->getContainerBuilder();
        try {
            $fileLocator = new FileLocator(__DIR__ . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader( $containerBuilder , $fileLocator);
            $loader->load('parameters.php');

            $this->command->setContainerBuilder( $containerBuilder );
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}