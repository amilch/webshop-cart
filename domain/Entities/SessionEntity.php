<?php

namespace Domain\Entities;

class SessionEntity
{
    public function __construct(
        private string $id,
    ) {}

    public function getId() {
        return $this->id;
    }
}
