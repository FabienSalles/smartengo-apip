<?php

namespace Smartengo\Infrastructure\Symfony\Messenger;

use Smartengo\Domain\Core\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * duplicate of internal ApiPlatform\Core\Bridge\Symfony\Messenger\DispatchTrait for CommandDataPersister.
     */
    public function handle($command)
    {
        try {
            return $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            // unwrap the exception thrown in handler for Symfony Messenger >= 4.3
            while ($e instanceof HandlerFailedException) {
                /** @var \Throwable $e */
                $e = $e->getPrevious();
            }

            throw $e;
        }
    }
}
