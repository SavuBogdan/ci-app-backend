<?php

namespace App\Message;


class NotificationMessage
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
     * @return NotificationMessage
     */
    public function setRef(string $ref): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setChangeRef(string $changeRef): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setType(string $type): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setBefore(string $before): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setAfter(string $after): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setRepositoryId(string $repositoryId): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setRepositoryName(string $repositoryName): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setCloneUrl(string $cloneUrl): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setCloneUrlSsh(string $cloneUrlSsh): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setPusher(string $pusher): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setPrNumber(?string $prNumber): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setPrTitle(?string $prTitle): NotificationMessage
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
     * @return NotificationMessage
     */
    public function setPrUrl(?string $prUrl): NotificationMessage
    {
        $this->prUrl = $prUrl;
        return $this;
    }
}