<?php

namespace Domain\Interfaces;


use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;

interface CartRepository
{
    public function insert(CartEntity $cart): CartEntity;

    public function delete(CartEntity $cart): void;

    public function all(?SessionEntity $session, ?UserEntity $user): array;
}
