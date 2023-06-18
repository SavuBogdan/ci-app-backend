<?php

namespace App\DTO;

class Container
{
    private string $id;
    private string $name;
    private string $image;
    private string $label;
    private array $commands;

    /** @var MountedVolume[] $volumes*/
    private array $volumes;

    public function __construct()
    {
        $this->commands = [];
        $this->volumes = [];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Container
     */
    public function setId(string $id): Container
    {
        $this->id = $id;
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
     * @return Container
     */
    public function setName(string $name): Container
    {
        $this->name = $name;
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
     * @return Container
     */
    public function setImage(string $image): Container
    {
        $this->image = $image;
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
     * @return Container
     */
    public function setLabel(string $label): Container
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    public function addCommand(string $command): Container
    {
        $this->commands[] = $command;
        return $this;
    }

    /**
     * @return array
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }

    public function mountVolume(Volume $volume, string $path): Container
    {
        $mountedVolume = (new MountedVolume())->setVolume($volume)->setMountPath($path);
        $this->volumes[] = $mountedVolume;
        return $this;
    }

}