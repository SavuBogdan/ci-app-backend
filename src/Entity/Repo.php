<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RepoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepoRepository::class)]
#[ApiResource]
class Repo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $repositoryId = null;

    #[ORM\OneToMany(mappedBy: 'repo', targetEntity: PullRequest::class)]
    private Collection $pullRequests;

    #[ORM\OneToMany(mappedBy: 'repo', targetEntity: Branch::class)]
    private Collection $branches;

    public function __construct()
    {
        $this->pullRequests = new ArrayCollection();
        $this->branches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepositoryId(): ?int
    {
        return $this->repositoryId;
    }

    public function setRepositoryId(int $repositoryId): self
    {
        $this->repositoryId = $repositoryId;

        return $this;
    }

    /**
     * @return Collection<int, PullRequest>
     */
    public function getPullRequests(): Collection
    {
        return $this->pullRequests;
    }

    public function addPullRequest(PullRequest $pullRequest): self
    {
        if (!$this->pullRequests->contains($pullRequest)) {
            $this->pullRequests->add($pullRequest);
            $pullRequest->setRepo($this);
        }

        return $this;
    }

    public function removePullRequest(PullRequest $pullRequest): self
    {
        if ($this->pullRequests->removeElement($pullRequest)) {
            // set the owning side to null (unless already changed)
            if ($pullRequest->getRepo() === $this) {
                $pullRequest->setRepo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Branch>
     */
    public function getBranches(): Collection
    {
        return $this->branches;
    }

    public function addBranch(Branch $branch): self
    {
        if (!$this->branches->contains($branch)) {
            $this->branches->add($branch);
            $branch->setRepo($this);
        }

        return $this;
    }

    public function removeBranch(Branch $branch): self
    {
        if ($this->branches->removeElement($branch)) {
            // set the owning side to null (unless already changed)
            if ($branch->getRepo() === $this) {
                $branch->setRepo(null);
            }
        }

        return $this;
    }
}
