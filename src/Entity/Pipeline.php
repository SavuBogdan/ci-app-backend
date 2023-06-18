<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PipelineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PipelineRepository::class)]
#[ApiResource]
class Pipeline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'pipelines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source = null;

    #[ORM\ManyToMany(targetEntity: Build::class, mappedBy: 'pipeline')]
    private Collection $builds;

    #[ORM\OneToMany(mappedBy: 'pipeline', targetEntity: Step::class, orphanRemoval: true)]
    private Collection $steps;

    public function __construct()
    {
        $this->builds = new ArrayCollection();
        $this->steps = new ArrayCollection();
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

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection<int, Build>
     */
    public function getBuilds(): Collection
    {
        return $this->builds;
    }

    public function addBuild(Build $build): self
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->addPipeline($this);
        }

        return $this;
    }

    public function removeBuild(Build $build): self
    {
        if ($this->builds->removeElement($build)) {
            $build->removePipeline($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setPipeline($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        // set the owning side to null (unless already changed)
        if ($this->steps->removeElement($step) && $step->getPipeline() === $this) {
            $step->setPipeline(null);
        }

        return $this;
    }
}
