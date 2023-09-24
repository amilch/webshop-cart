<?php

namespace Domain\Interfaces;

use Domain\Entities\SessionEntity;

interface SessionService
{
    public function getSession(): SessionEntity;
}
