<?php

namespace Domain\Interfaces;


interface CartFactory
{
    public function make(array $attributes = []): CartEntity;
}
