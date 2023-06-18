<?php

namespace App\Command;

use App\DTO\ContainerConfiguration;
use App\DTO\VolumeConfiguration;
use App\Exceptions\ContainerCreationException;
use App\Exceptions\DockerCommandException;
use App\Exceptions\VolumeCopyException;
use App\Exceptions\VolumeCreationException;
use App\Factory\ContainerFactory;
use App\Factory\VolumeFactory;
use App\Service\DockerContainerService;
use App\Service\DockerService;
use App\Service\DockerVolumeService;
use App\Service\VersionControlSystemService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    public function __construct(
        private readonly DockerContainerService $dockerContainerService,
        private readonly DockerVolumeService $dockerVolumeService,
        private readonly VersionControlSystemService $vcsService
    )
    {
        parent::__construct();
    }



    protected function configure(): void
    {
        $this
            ->setDescription('Testing DOCKER COMMANDS')
            ->setName($this::$defaultName);
    }

    /**
     * @throws ContainerCreationException
     * @throws VolumeCreationException
     * @throws DockerCommandException
     * @throws VolumeCopyException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $volumeFactory = new VolumeFactory();
        $containerFactory = new ContainerFactory();

        $volumeConfig = (new VolumeConfiguration())->setName('vcs-test-volume')->setLabel('test-volume');
        $volume = $volumeFactory->create($volumeConfig);

        $this->vcsService->cloneInVolume($volume, 'https://github.com/SavuBogdan/todoApp.git');
        $newVolume = $this->vcsService->gitCopyVolume($volume, 'volume-vcs-copy');


        $containerConfig = (new ContainerConfiguration())
            ->setName('test-php-container')
            ->setLabel('test-label-container')
            ->setImage('php:7.4.33-fpm')
            ->mountVolume($volume, '/var/www/html')
            ->mountVolume($newVolume, '/var/www/new-html');
        $container = $containerFactory->create($containerConfig);

        $this->dockerContainerService->runCommandInContainer($container->getId(), 'ls -la /var/www/html', true);
        $this->dockerContainerService->runCommandInContainer($container->getId(), 'ls -la /var/www/new-html', true);

        $this->dockerContainerService->deleteContainer($container);

        $this->dockerVolumeService->removeVolume($volume);
        $this->dockerVolumeService->removeVolume($newVolume);


        return Command::SUCCESS;
    }

}