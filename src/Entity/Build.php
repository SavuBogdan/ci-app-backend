<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BuildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildRepository::class)]
#[ApiResource]
class Build
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Pipeline::class, inversedBy: 'builds')]
    private Collection $pipeline;

    public function __construct()
    {
        $this->pipeline = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Pipeline>
     */
    public function getPipeline(): Collection
    {
        return $this->pipeline;
    }

    public function addPipeline(Pipeline $pipeline): self
    {
        if (!$this->pipeline->contains($pipeline)) {
            $this->pipeline->add($pipeline);
        }

        return $this;
    }

    public function removePipeline(Pipeline $pipeline): self
    {
        $this->pipeline->removeElement($pipeline);

        return $this;
    }
}
