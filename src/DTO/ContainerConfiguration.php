<?php

namespace App\DTO;

class ContainerConfiguration
{
    private string $user = '1000:1000';
    private string $name;
    private string $label;
    private string $image;

    /** @var MountedVolume[] $volumes */
    private array $volumes = [];

    /** @var SourceFileMount[] $sourceFileMounts */
    private array $sourceFileMounts = [];
    private ?string $workDir = null;

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return ContainerConfiguration
     */
    public function setUser(string $user): ContainerConfiguration
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ContainerConfiguration
     */
    public function setName(string $name): ContainerConfiguration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return ContainerConfiguration
     */
    public function setLabel(string $label): ContainerConfiguration
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return ContainerConfiguration
     */
    public function setImage(string $image): ContainerConfiguration
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return array
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }

    public function mountVolume(Volume $volume, string $path): ContainerConfiguration
    {
        $mountedVolume = (new MountedVolume())->setVolume($volume)->setMountPath($path);
        $this->volumes[] = $mountedVolume;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWorkDir(): ?string
    {
        return $this->workDir;
    }

    /**
     * @param string $workDir
     * @return ContainerConfiguration
     */
    public function setWorkDir(string $workDir): ContainerConfiguration
    {
        $this->workDir = $workDir;
        return $this;
    }

    /**
     * @return array
     */
    public function getSourceFileMounts(): array
    {
        return $this->sourceFileMounts;
    }


public function addSourceFileMount(SourceFileMount $sourceFileMount): ContainerConfiguration
    {
        $this->sourceFileMounts[] = $sourceFileMount;
        return $this;
    }

}