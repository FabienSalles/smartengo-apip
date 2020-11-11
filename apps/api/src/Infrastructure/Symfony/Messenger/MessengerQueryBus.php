<?php

namespace Smartengo\Infrastructure\Symfony\Messenger;

use Smartengo\Domain\Core\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerQueryBus implements QueryBus
{
    /** @var MessageBusInterface */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function handle($query)
    {
        try {
            $envelope = $this->messageBus->dispatch($query);

            /** @var HandledStamp $handledStamp */
            $handledStamp = $envelope->last(HandledStamp::class);

            return $handledStamp->getResult();
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
