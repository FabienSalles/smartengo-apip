<?php

namespace Smartengo\Infrastructure\ApiPlatform\Messenger\DataPersister;

use ApiPlatform\Core\Bridge\Symfony\Messenger\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Smartengo\Domain\Core\CommandBus;
use Smartengo\Domain\Core\IdentifierAwareCommand;

final class CommandDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var ContextAwareDataPersisterInterface */
    private $dataPersister;

    /** @var CommandBus */
    private $commandBus;

    public function __construct(DataPersister $dataPersister, CommandBus $commandBus)
    {
        $this->dataPersister = $dataPersister;
        $this->commandBus = $commandBus;
    }

    /**
     * @param mixed $data
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof IdentifierAwareCommand
            && $this->dataPersister->supports($data, $context);
    }

    /**
     * @param mixed $data
     */
    public function persist($data, array $context = []): void
    {
        $this->commandBus->handle($data);
    }

    /**
     * @param mixed $data
     */
    public function remove($data, array $context = []): void
    {
        $this->commandBus->handle($data);
    }
}
