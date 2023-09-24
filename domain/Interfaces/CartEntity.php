<?php

namespace Domain\Interfaces;


use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;

interface CartEntity
{
    public function getItems(): array;

    public function getUser(): ?UserEntity;

    public function getSession(): ?SessionEntity;
}
