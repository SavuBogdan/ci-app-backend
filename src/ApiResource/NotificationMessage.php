<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\NotificationController;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/notify',
            status: 201,
            controller: NotificationController::class,
            description: 'Create a notification',
            name: 'notify'
        )
    ]
)]
class Notification
{
    private string $ref;
    private ?string $changeRef = null;
    private string $type;
    private string $before;
    private string $after;
    private string $repositoryId;
    private string $repositoryName;
    private string $cloneUrl;
    private string $cloneUrlSsh;
    private string $pusher;
    private ?string $prNumber = null;
    private ?string $prTitle = null;
    private ?string $prUrl = null;


    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     * @return Notification
     */
    public function setRef(string $ref): Notification
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @return string
     */
    public function getChangeRef(): string
    {
        return $this->changeRef;
    }

    /**
     * @param string $changeRef
     * @return Notification
     */
    public function setChangeRef(string $changeRef): Notification
    {
        $this->changeRef = $changeRef;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Notification
     */
    public function setType(string $type): Notification
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getBefore(): string
    {
        return $this->before;
    }

    /**
     * @param string $before
     * @return Notification
     */
    public function setBefore(string $before): Notification
    {
        $this->before = $before;
        return $this;
    }

    /**
     * @return string
     */
    public function getAfter(): string
    {
        return $this->after;
    }

    /**
     * @param string $after
     * @return Notification
     */
    public function setAfter(string $after): Notification
    {
        $this->after = $after;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryId(): string
    {
        return $this->repositoryId;
    }

    /**
     * @param string $repositoryId
     * @return Notification
     */
    public function setRepositoryId(string $repositoryId): Notification
    {
        $this->repositoryId = $repositoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    /**
     * @param string $repositoryName
     * @return Notification
     */
    public function setRepositoryName(string $repositoryName): Notification
    {
        $this->repositoryName = $repositoryName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCloneUrl(): string
    {
        return $this->cloneUrl;
    }

    /**
     * @param string $cloneUrl
     * @return Notification
     */
    public function setCloneUrl(string $cloneUrl): Notification
    {
        $this->cloneUrl = $cloneUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCloneUrlSsh(): string
    {
        return $this->cloneUrlSsh;
    }

    /**
     * @param string $cloneUrlSsh
     * @return Notification
     */
    public function setCloneUrlSsh(string $cloneUrlSsh): Notification
    {
        $this->cloneUrlSsh = $cloneUrlSsh;
        return $this;
    }

    /**
     * @return string
     */
    public function getPusher(): string
    {
        return $this->pusher;
    }

    /**
     * @param string $pusher
     * @return Notification
     */
    public function setPusher(string $pusher): Notification
    {
        $this->pusher = $pusher;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrNumber(): ?string
    {
        return $this->prNumber;
    }

    /**
     * @param string|null $prNumber
     * @return Notification
     */
    public function setPrNumber(?string $prNumber): Notification
    {
        $this->prNumber = $prNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrTitle(): ?string
    {
        return $this->prTitle;
    }

    /**
     * @param string|null $prTitle
     * @return Notification
     */
    public function setPrTitle(?string $prTitle): Notification
    {
        $this->prTitle = $prTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrUrl(): ?string
    {
        return $this->prUrl;
    }

    /**
     * @param string|null $prUrl
     * @return Notification
     */
    public function setPrUrl(?string $prUrl): Notification
    {
        $this->prUrl = $prUrl;
        return $this;
    }
}