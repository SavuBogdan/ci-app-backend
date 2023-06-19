<?php

namespace App\Service;

use App\DTO\Container;
use App\DTO\Volume;
use App\Exceptions\DockerCommandException;
use Symfony\Component\Process\Process;

readonly class DockerContainerService extends AbstractCommandService
{

    private function getContainerIdsByLabel(string $label): array
    {
        $process = new Process(['docker', 'ps', '-aq', '--filter', 'label=' . $label]);
        $process->run();

        if ($process->isSuccessful()) {
            return explode("\n", trim($process->getOutput()));
        } else {
            echo 'Error retrieving container IDs: ' . $process->getErrorOutput();
        }

        return [];
    }

    public function listContainers(?string $label = null): array
    {
        $command = [
            'docker',
            'ps',
            '-a',
            '--format',
            '{"ID":"{{ .ID }}", "Image": "{{ .Image }}", "Names":"{{ .Names }}", "State":"{{ .State }}", "Labels":"{{ .Labels }}"}'
        ];

        if ($label) {
            $command[] = '--filter';
            $command[] = 'label=' . $label;
        }

        $this->runCommand($command);

        return [];
    }

    private function stopContainers(array $containerIds): void
    {
        echo 'Stopping containers: ' . implode(', ', $containerIds) . "\n";
        $process = new Process(['docker', 'container', 'stop', ...$containerIds]);
        $process->run();

        if (!$process->isSuccessful()) {
            echo 'Error stopping container: ' . $process->getErrorOutput();
        }
    }

    private function removeContainers(array $containerIds): void
    {
        echo 'Deleting containers: ' . implode(', ', $containerIds) . "\n";
        $process = new Process(['docker', 'rm', ...$containerIds]);
        $process->run();

        if (!$process->isSuccessful()) {
            echo 'Error deleting container: ' . $process->getErrorOutput();
        }
    }

    public function deleteContainer(Container $container): void
    {
        $this->stopContainers([$container->getId()]);
        $this->removeContainers([$container->getId()]);
    }

    public function deleteContainersByLabel($label): void
    {
        $containerIds = $this->getContainerIdsByLabel($label);

        if (!empty($containerIds)) {
            $this->stopContainers($containerIds);
            $this->removeContainers($containerIds);
        }
    }

    /**
     * @throws DockerCommandException
     */
    public function runCommandInContainer(string $containerId, string $command, $shouldPrintOutput = false, string $user = null): void
    {
        $commandParts = ['docker', 'exec','-t'];

        if ($user) {
            $commandParts[] = '--user';
            $commandParts[] = $user;
        }
        $commandParts = array_merge($commandParts, [$containerId, ...explode(' ', $command)]);


        if ($shouldPrintOutput) {
            echo 'Running command: ' . implode(' ', $commandParts) . "\n";

            $process = $this->runCommand($commandParts, true);
        } else {
            $process = new Process($commandParts);
            $process->run();
        }

        if (!$process->isSuccessful()) {
            echo 'Error running command: ' . $process->getErrorOutput() . PHP_EOL;
            throw new DockerCommandException($command);
        }
    }
}