<?php

namespace App\Services;

use Domain\Entities\SessionEntity;

class SessionService implements \Domain\Interfaces\SessionService
{
    public function getSession(): SessionEntity
    {
        return new SessionEntity(session()->getId());
    }
}
