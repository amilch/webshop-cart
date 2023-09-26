<?php

namespace Domain\Interfaces;


use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;

interface CartEntity
{
    public function getItems(): array;

    public function getWithSku(string $sku): ?CartItemEntity;

    public function add(CartItemEntity $cartItem): void;

    public function getUser(): ?UserEntity;

    public function getSession(): ?SessionEntity;
}
