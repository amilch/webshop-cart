<?php

namespace App\Factories;

use App\Models\Cart;
use App\Models\Category;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;

class CartModelFactory implements CartFactory
{
    public function make(array $attributes = []): CartEntity
    {
        $cart = new Cart($attributes);
        return $cart;
    }
}
