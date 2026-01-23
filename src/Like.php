<?php

namespace src;

use App\ValueObject\UUID;

class Like
{
    private $uuid;

    private $postUuid;

    private $userUuid;

    public function __construct(UUID $uuid, UUID $postUuid, UUID $userUuid)
    {
        $this->uuid = $uuid;
        $this->postUuid = $postUuid;
        $this->userUuid = $userUuid;
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getPostUuid(): UUID
    {
        return $this->postUuid;
    }

    public function getUserUuid(): UUID
    {
        return $this->userUuid;
    }
}