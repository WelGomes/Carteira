<?php

namespace projeto\src\model;

final class CaseCrypto
{

    private int $id;
    private int $userId;

    public function __construct(
        int $userId
    ) {
        $this->userId = $userId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
