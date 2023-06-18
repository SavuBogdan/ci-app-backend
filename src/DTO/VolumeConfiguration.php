<?php

namespace App\DTO;

class VolumeConfiguration
{
    private string $name;
    private string $label;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return VolumeConfiguration
     */
    public function setName(string $name): VolumeConfiguration
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
     * @return VolumeConfiguration
     */
    public function setLabel(string $label): VolumeConfiguration
    {
        $this->label = $label;
        return $this;
    }


}