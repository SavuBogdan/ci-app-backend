<?php

namespace App\Factory;

use App\DTO\Container;
use App\DTO\ContainerConfiguration;
use App\Exceptions\ContainerCreationException;
use App\Service\AbstractCommandService;
use Symfony\Component\Process\Process;

readonly class ContainerFactory extends AbstractCommandService implements ContainerFactoryInterface
{
    /**
     * @param ContainerConfiguration $config
     * @return Container
     * @throws ContainerCreationException
     */
    public function create(ContainerConfiguration $config): Container
    {

        $volumesParts = [];
        foreach ($config->getVolumes() as $volume) {
            $volumesParts[] = '-v';
            $volumesParts[] = sprintf('%s:%s', $volume->getVolume()->getName(), $volume->getMountPath());
        }
        $command = ['docker', 'run', '-d', '-t', '--name', $config->getName(), '--label', $config->getLabel(), ...$volumesParts];

        if (!empty($config->getSourceFileMounts())) {
            foreach ($config->getSourceFileMounts() as $sourceFileMount) {
                $command[] = '--mount';
                $command[] = sprintf('type=%s,source=%s,target=%s,readonly', $sourceFileMount->getType(), $sourceFileMount->getSourcePath(), $sourceFileMount->getMountPath());
            }
        }

        if (!empty($config->getWorkDir())) {
            $command[] = '-w';
            $command[] = $config->getWorkDir();
        }

        $command[] = $config->getImage();

        $process = $this->runCommand($command);

        if (!$process->isSuccessful()) {
            echo $process->getErrorOutput();
        }

        $containerId = $this->getContainerId($config->getName());


        if (!$containerId) {
            throw new ContainerCreationException();
        }

        echo sprintf("Successfully created container with id: %s and name: %s\n", $containerId, $config->getName());

        return (new Container())
            ->setId($containerId)
            ->setName($config->getName())
            ->setLabel($config->getLabel())
            ->setImage($config->getImage());
    }

    private function getContainerId(string $name): string
    {
        $command = ['docker', 'ps', '-aq', '--filter', 'name=' . $name];
        $process = new Process($command);
        $process->start();
        $process->wait();
        $output = $process->getOutput();

        return trim($output);
    }
}