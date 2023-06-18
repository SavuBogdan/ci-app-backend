<?php

namespace App\DTO;

class MountedVolume
{
    private Volume $volume;
    private string $mountPath;

    /**
     * @return Volume
     */
    public function getVolume(): Volume
    {
        return $this->volume;
    }

    /**
     * @param Volume $volume
     * @return MountedVolume
     */
    public function setVolume(Volume $volume): MountedVolume
    {
        $this->volume = $volume;
        return $this;
    }

    /**
     * @return string
     */
    public function getMountPath(): string
    {
        return $this->mountPath;
    }

    /**
     * @param string $mountPath
     * @return MountedVolume
     */
    public function setMountPath(string $mountPath): MountedVolume
    {
        $this->mountPath = $mountPath;
        return $this;
    }



}