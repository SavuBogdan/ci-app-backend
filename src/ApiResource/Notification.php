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
class Notification
{
    private string $test;

    /**
     * @return string
     */
    public function getTest(): string
    {
        return $this->test;
    }

    /**
     * @param string $test
     * @return Notification
     */
    public function setTest(string $test): Notification
    {
        $this->test = $test;
        return $this;
    }


}