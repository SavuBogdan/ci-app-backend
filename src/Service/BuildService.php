<?php

namespace App\Service;

use App\Entity\Build;
use App\Message\NotificationMessage;

class BuildService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function build(NotificationMessage $message): void
    {
        $build = $this->startBuild($message);

    }

    private function startBuild(NotificationMessage $message): Build
    {
        $build = new Build();
//        $build->);
    }
}