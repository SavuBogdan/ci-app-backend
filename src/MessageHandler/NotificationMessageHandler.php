<?php

namespace App\MessageHandler;

use App\Message\NotificationMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotificationMessageHandler
{

    public function __construct()
    {
    }

    public function __invoke(NotificationMessage $message): void
    {
        dump($message);
    }

}