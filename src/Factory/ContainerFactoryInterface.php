<?php

namespace App\Factory;

use App\DTO\Container;
use App\DTO\ContainerConfiguration;
use App\Exceptions\ContainerCreationException;

interface ContainerFactoryInterface
{
    /**
     * @param ContainerConfiguration $config
     * @return Container
     * @throws ContainerCreationException
     */
    public function create(ContainerConfiguration $config): Container;
}