<?php

namespace App\Producer;

use App\Builder\NotificationMessageBuilder;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class NotificationMessageProducer
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(array $data): void
    {
        $builder = new NotificationMessageBuilder();
        $message = $builder->build($data);
        $this->messageBus->dispatch($message);
    }
}