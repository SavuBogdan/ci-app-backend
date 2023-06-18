<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ApiResource]
class Source
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\OneToMany(mappedBy: 'source', targetEntity: Pipeline::class, orphanRemoval: true)]
    private Collection $pipelines;

    public function __construct()
    {
        $this->pipelines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Pipeline>
     */
    public function getPipelines(): Collection
    {
        return $this->pipelines;
    }

    public function addPipeline(Pipeline $pipeline): self
    {
        if (!$this->pipelines->contains($pipeline)) {
            $this->pipelines->add($pipeline);
            $pipeline->setSource($this);
        }

        return $this;
    }

    public function removePipeline(Pipeline $pipeline): self
    {
        if ($this->pipelines->removeElement($pipeline)) {
            // set the owning side to null (unless already changed)
            if ($pipeline->getSource() === $this) {
                $pipeline->setSource(null);
            }
        }

        return $this;
    }
}
