<?php

namespace App\Services;

use Domain\Entities\UserEntity;
use Domain\Interfaces\AuthService;
use Illuminate\Support\Facades\Auth;

class KeycloakAuthService implements AuthService
{

    public function getCurrentUser(): ?UserEntity
    {
        $id = json_decode(Auth::token())?->sub;
        return $id ? new UserEntity($id) : null;
    }
}
