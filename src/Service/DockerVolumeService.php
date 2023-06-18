<?php

namespace App\Service;

use App\DTO\Volume;

readonly class DockerVolumeService extends AbstractCommandService
{

    public function listVolumes(?string $label = null): void
    {
        $command = [
            'docker',
            'volume',
            'ls',
            '--format',
            '{"Name":"{{ .Name }}", "Driver": "{{ .Driver }}", "Labels":"{{ .Labels }}"}'
        ];

        if ($label) {
            $command[] = '--filter';
            $command[] = 'label=' . $label;
        }

        $this->runCommand($command);
    }

    public function removeVolume(Volume $volume): void
    {

        $command = ['docker', 'volume', 'rm', $volume->getName()];

        $process = $this->runCommand($command, true);

        if (!$process->isSuccessful()) {
            echo 'Error removing volume: ' . $process->getErrorOutput();
        }
    }
}