<?php

namespace App\Factory;

use App\DTO\Volume;
use App\DTO\VolumeConfiguration;
use App\Exceptions\VolumeCreationException;
use App\Service\AbstractCommandService;

readonly class VolumeFactory extends AbstractCommandService implements VolumeFactoryInterface
{
    /**
     * @throws VolumeCreationException
     */
    public function create(VolumeConfiguration $config): Volume
    {
        $command = ['docker', 'volume', 'create', "--label", $config->getLabel(), $config->getName()];

        $process = $this->runCommand($command);

        if (!$process->isSuccessful()) {
            throw new VolumeCreationException($process->getErrorOutput());
        }

        echo sprintf("Successfully created volume with name: %s and label: %s\n", $config->getName(), $config->getLabel());

        return (new Volume())->setName($config->getName())->setLabel($config->getLabel());
    }
}