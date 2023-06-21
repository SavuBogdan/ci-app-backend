<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PullRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PullRequestRepository::class)]
#[ApiResource]
class PullRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $pusher = null;

    #[ORM\ManyToOne(inversedBy: 'pullRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Repo $repo = null;

    #[ORM\Column(length: 255)]
    private ?string $baseRef = null;

    #[ORM\Column(length: 255)]
    private ?string $changeRef = null;

    #[ORM\Column(length: 255)]
    private ?string $baseCommit = null;

    #[ORM\Column(length: 255)]
    private ?string $headCommit = null;

    #[ORM\OneToMany(mappedBy: 'pullRequest', targetEntity: Build::class)]
    private Collection $builds;

    public function __construct()
    {
        $this->builds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getRepo(): ?Repo
    {
        return $this->repo;
    }

    public function setRepo(?Repo $repo): self
    {
        $this->repo = $repo;

        return $this;
    }

    public function getBaseRef(): ?string
    {
        return $this->baseRef;
    }

    public function setBaseRef(string $baseRef): self
    {
        $this->baseRef = $baseRef;

        return $this;
    }

    public function getChangeRef(): ?string
    {
        return $this->changeRef;
    }

    public function setChangeRef(string $changeRef): self
    {
        $this->changeRef = $changeRef;

        return $this;
    }

    public function getBaseCommit(): ?string
    {
        return $this->baseCommit;
    }

    public function setBaseCommit(string $baseCommit): self
    {
        $this->baseCommit = $baseCommit;

        return $this;
    }

    public function getHeadCommit(): ?string
    {
        return $this->headCommit;
    }

    public function setHeadCommit(string $headCommit): self
    {
        $this->headCommit = $headCommit;

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
            $build->setPullRequest($this);
        }

        return $this;
    }

    public function removeBuild(Build $build): self
    {
        if ($this->builds->removeElement($build)) {
            // set the owning side to null (unless already changed)
            if ($build->getPullRequest() === $this) {
                $build->setPullRequest(null);
            }
        }

        return $this;
    }
}
