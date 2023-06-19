<?php

namespace App\Service;

use App\DTO\ContainerConfiguration;
use App\DTO\SourceFileMount;
use App\DTO\Volume;
use App\DTO\VolumeConfiguration;
use App\Exceptions\ContainerCreationException;
use App\Exceptions\DockerCommandException;
use App\Exceptions\VolumeCopyException;
use App\Exceptions\VolumeCreationException;
use App\Factory\ContainerFactory;
use App\Factory\VolumeFactory;
use Symfony\Component\Process\Process;

readonly class VersionControlSystemService extends AbstractCommandService
{


    public function __construct(private DockerContainerService $dockerContainerService)
    {
    }


    /**
     * @throws ContainerCreationException
     * @throws DockerCommandException
     */
    public function cloneInVolume(Volume $volume, $gitUrl): void
    {
        $sshMount = (new SourceFileMount())->setSourcePath('/home/raizeno/.ssh')->setMountPath('/home/appuser/.ssh');

        $containerFactory = new ContainerFactory();
        $containerConfig = (new ContainerConfiguration())
            ->setName('gitContainer')
            ->setLabel('gitContainerLabel')
            ->setImage('bitnami/git:latest')
            ->mountVolume($volume, '/git')
            ->addSourceFileMount($sshMount)
            ->setWorkDir('/git');

        echo "Creating temporary git container: " . $volume->getName() . "\n";


        $container = $containerFactory->create($containerConfig);

        $this->dockerContainerService->runCommandInContainer($container->getId(), 'ls -al /home/appuser/.ssh');
        $this->dockerContainerService->runCommandInContainer($container->getId(), 'groupadd -g 1000 appuser',);
        $this->dockerContainerService->runCommandInContainer($container->getId(), 'useradd -u 1000 -g appuser -s /bin/sh -m appuser');
        $this->dockerContainerService->runCommandInContainer($container->getId(), 'chown -R appuser:appuser /git',);
        $this->dockerContainerService->runCommandInContainer($container->getId(), 'chmod -R 755 /git');

        $command = ['docker', 'exec', '-t', '--user', 'appuser', $container->getName(), 'git', 'clone', '--progress', $gitUrl, '.'];

        echo "Cloning repository in volume: " . $volume->getName() . "\n";
        echo "Cloning repository from url: " . $gitUrl . "\n";
        $this->runCommand($command);

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

        $command = ['docker','run','--rm', '-t', '-v', $oldVolume->getName() . ':/from','-v',$newVolume->getName() . ':/to','alpine','sh','-c', 'cp -av /from/. /to'];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new VolumeCopyException($process->getErrorOutput());
        }

        return $newVolume;
    }
}