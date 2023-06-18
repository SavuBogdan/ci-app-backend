<?php

namespace App\Factory;

use App\DTO\Volume;
use App\DTO\VolumeConfiguration;

interface VolumeFactoryInterface
{
    public function create(VolumeConfiguration $config): Volume;
}