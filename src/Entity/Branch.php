<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BranchRepository::class)]
#[ApiResource]
class Branch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'branches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Repo $repo = null;

    #[ORM\Column(length: 255)]
    private ?string $ref = null;

    #[ORM\Column(length: 255)]
    private ?string $beforeCommit = null;

    #[ORM\Column(length: 255)]
    private ?string $afterCommit = null;

    #[ORM\Column(length: 255)]
    private ?string $pusher = null;

    #[ORM\OneToMany(mappedBy: 'branch', targetEntity: Build::class)]
    private Collection $builds;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct()
    {
        $this->builds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepo(): ?Repo
    {
        return $this->repo;
    }

    public function setRepo(?Repo $repo): self
    {
        $this->repo = $repo;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getBeforeCommit(): ?string
    {
        return $this->beforeCommit;
    }

    public function setBeforeCommit(string $beforeCommit): self
    {
        $this->beforeCommit = $beforeCommit;

        return $this;
    }

    public function getAfterCommit(): ?string
    {
        return $this->afterCommit;
    }

    public function setAfterCommit(string $afterCommit): self
    {
        $this->afterCommit = $afterCommit;

        return $this;
    }

    public function getPusher(): ?string
    {
        return $this->pusher;
    }

    public function setPusher(string $pusher): self
    {
        $this->pusher = $pusher;

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
            $build->setBranch($this);
        }

        return $this;
    }

    public function removeBuild(Build $build): self
    {
        if ($this->builds->removeElement($build)) {
            // set the owning side to null (unless already changed)
            if ($build->getBranch() === $this) {
                $build->setBranch(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
