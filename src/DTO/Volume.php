<?php

namespace App\DTO;

class Volume
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
     * @return Volume
     */
    public function setName(string $name): Volume
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
     * @return Volume
     */
    public function setLabel(string $label): Volume
    {
        $this->label = $label;
        return $this;
    }



}