<?php

namespace Domain\Interfaces;


interface CartItemFactory
{
    public function make(array $attributes = []): CartItemEntity;
}
