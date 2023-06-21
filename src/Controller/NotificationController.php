<?php

namespace App\Controller;

use App\ApiResource\Notify;
use App\Producer\NotificationMessageProducer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class NotificationController extends AbstractController
{
    public function __construct(readonly private NotificationMessageProducer $notificationMessageProducer)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->notificationMessageProducer->dispatch($data);

        return new JsonResponse(['success' => true], 201);
    }
}