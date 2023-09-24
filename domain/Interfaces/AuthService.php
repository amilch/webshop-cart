<?php

namespace Domain\Interfaces;

use Domain\Entities\UserEntity;

interface AuthService
{
    public function getCurrentUser(): ?UserEntity;
}
