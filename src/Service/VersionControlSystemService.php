<?php

namespace App\Service;

use App\DTO\ContainerConfiguration;
use App\DTO\Volume;
use App\DTO\VolumeConfiguration;
use App\Exceptions\ContainerCreationException;
use App\Exceptions\VolumeCopyException;
use App\Exceptions\VolumeCreationException;
use App\Factory\ContainerFactory;
use App\Factory\VolumeFactory;
use Symfony\Component\Process\Process;

readonly class VersionControlSystemService extends AbstractCommandService
{


    public function __construct(
        private readonly DockerVolumeService    $dockerVolumeService,
        private readonly DockerContainerService $dockerContainerService
    )
    {
    }

    /**
     * @throws ContainerCreationException
     */
    public function cloneInVolume(Volume $volume, string $gitUrl): void
    {
        $this->gitCloneInVolume($volume, $gitUrl);
    }


    /**
     * @throws ContainerCreationException
     */
    private function gitCloneInVolume(Volume $volume, $gitUrl): void
    {
        $containerFactory = new ContainerFactory();
        $containerConfig = (new ContainerConfiguration())
            ->setName('gitContainer')
            ->setLabel('gitContainerLabel')
            ->setImage('bitnami/git:latest')
            ->mountVolume($volume, '/git')
            ->setWorkDir('/git');

        echo "Creating temporary git container: " . $volume->getName() . "\n";


        $container = $containerFactory->create($containerConfig);

        $command = ['docker', 'exec', $container->getName(), 'git', 'clone', '--progress', $gitUrl, '.'];

        echo "Cloning repository in volume: " . $volume->getName() . "\n";
        echo "Cloning repository from url: " . $gitUrl . "\n";
        $this->runCommandWithoutIterativeOutput($command);

        $this->dockerContainerService->deleteContainer($container);
    }

    /**
     * @throws VolumeCopyException|VolumeCreationException
     */
    public function gitCopyVolume(Volume $oldVolume, string $newVolumeName): Volume
    {
        $volumeFactory = new VolumeFactory();
        $volumeConfig = (new VolumeConfiguration())->setName($newVolumeName)->setLabel($oldVolume->getLabel());
        $newVolume = $volumeFactory->create($volumeConfig);

        $command = ['docker','run','--rm','-v', $oldVolume->getName() . ':/from','-v',$newVolume->getName() . ':/to','alpine','sh','-c', 'cp -av /from/. /to'];
        // docker run --rm -v original_volume:/from -v new_volume:/to alpine ash -c "cd /from && cp -av . /to"

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new VolumeCopyException($process->getErrorOutput());
        }

        $this->runCommand($command, true);
        return $newVolume;
    }

}