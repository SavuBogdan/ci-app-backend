<?php

namespace App\DTO;

class SourceFileMount
{
    private string $type = 'bind';
    private string $sourcePath;
    private string $mountPath;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return SourceFileMount
     */
    public function setType(string $type): SourceFileMount
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    /**
     * @param string $sourcePath
     * @return SourceFileMount
     */
    public function setSourcePath(string $sourcePath): SourceFileMount
    {
        $this->sourcePath = $sourcePath;
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
     * @return SourceFileMount
     */
    public function setMountPath(string $mountPath): SourceFileMount
    {
        $this->mountPath = $mountPath;
        return $this;
    }

}