<?php

namespace App\Builder;

use App\Message\NotificationMessage;

class NotificationMessageBuilder
{
    const NEW_BRANCH = 'NEW_BRANCH';
    const BRANCH_PUSH = 'BRANCH_PUSH';
    const BRANCH_DELETED = 'BRANCH_DELETED';
    const PR_OPENED = 'PR_OPENED';
    const PR_REOPENED = 'PR_REOPENED';
    const PR_CLOSED = 'PR_CLOSED';
    const PR_SYNCHRONIZE = 'PR_SYNCHRONIZE';

    public function build(array $data): ?NotificationMessage
    {
        $notification = new NotificationMessage();

        if (!isset($data['action'])) {
            $notification->setRef($data['ref']);
            if ($data['created'] === true) {
                $notification->setType(self::NEW_BRANCH);
            } elseif ($data['deleted'] === true) {
                $notification->setType(self::BRANCH_DELETED);
            }else {
                $notification->setType(self::BRANCH_PUSH);
            }

            $notification
                ->setBefore($data['before'])
                ->setAfter($data['after'])
                ->setCloneUrl($data['repository']['clone_url'])
                ->setCloneUrlSsh($data['repository']['ssh_url'])
                ->setRepositoryName($data['repository']['name'])
                ->setRepositoryId($data['repository']['id'])
                ->setPusher($data['pusher']['name']);

        } else {
            if ($data['action'] === 'opened') {
                $notification->setType(self::PR_OPENED);
            } elseif ($data['action'] === 'reopened') {
                $notification->setType(self::PR_REOPENED);
            } elseif ($data['action'] === 'closed') {
                $notification->setType(self::PR_CLOSED);
            } elseif ($data['action'] === 'synchronize') {
                $notification->setType(self::PR_SYNCHRONIZE);
            } else {
                return null;
            }

            $notification
                ->setRef($data['pull_request']['base']['ref'])
                ->setChangeRef($data['pull_request']['head']['ref'])
                ->setBefore($data['pull_request']['base']['sha'])
                ->setAfter($data['pull_request']['head']['sha'])
                ->setRepositoryName($data['repository']['name'])
                ->setRepositoryId($data['repository']['id'])
                ->setCloneUrl($data['repository']['clone_url'])
                ->setCloneUrlSsh($data['repository']['ssh_url'])
                ->setPusher($data['sender']['login'])
                ->setPrNumber($data['pull_request']['number'])
                ->setPrTitle($data['pull_request']['title'])
                ->setPrUrl($data['pull_request']['html_url'])
            ;
        }


        return $notification;
    }

}