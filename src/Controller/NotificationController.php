<?php

namespace App\Controller;

use App\ApiResource\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class NotificationController extends AbstractController
{

    public function __invoke(Request $request): JsonResponse
    {
        dump(json_decode($request->getContent(), true));

        return new JsonResponse(['success' => true], 201);
    }
}