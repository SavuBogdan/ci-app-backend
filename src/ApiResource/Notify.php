<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\NotificationController;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/notify',
            status: 201,
            controller: NotificationController::class,
            description: 'Create a notification',
            name: 'notify'
        )
    ]
)]
class Notify
{
}