<?php

namespace App\Repositories;

use App\Models\Cart;
use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartRepository;

class CartDatabaseRepository implements CartRepository
{
    public function insert(CartEntity $cart): CartEntity
    {
        return Cart::create([
            'session_id' => $cart->getSession()?->getId(),
            'user_id' => $cart->getUser()?->getId(),
        ]);
    }

    public function delete(CartEntity $cart): void
    {
        Cart::find($cart->id)->delete();
    }

    public function all(?SessionEntity $session = null, ?UserEntity $user = null,): array
    {
        $builder = Cart::query();

        if ($session !== null)
        {
            $builder = $builder->where('session_id', $session->getId());
        }

        if ($user !== null)
        {
            $builder = $builder->orWhere('user_id', $user->getId());
        }

        return $builder->get()->all();
    }
}
