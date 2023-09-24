<?php

namespace Domain\Entities;

class UserEntity
{
    public function __construct(
        private readonly string $id,
    ) {}

    public function getId() {
        return $this->id;
    }
}
