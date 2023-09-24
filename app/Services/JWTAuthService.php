<?php

namespace App\Services;

use Domain\Entities\UserEntity;
use Domain\Interfaces\AuthService;

class JWTAuthService implements AuthService
{

    public function getCurrentUser(): ?UserEntity
    {
//        return new UserEntity("user-id");
        return null;
    }
}
