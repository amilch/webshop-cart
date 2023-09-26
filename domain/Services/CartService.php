<?php

namespace Domain\Services;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartRepository;
use Domain\ValueObjects\MoneyValueObject;

class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private AuthService $authService,
        private CartFactory $cartFactory,
    ) {}

    public function mergeCartsOfUserAndSession(SessionEntity $session, bool $create_new = false): bool
    {
        $user = $this->authService->getCurrentUser();
        $merged = false;

        $session_carts = $this->cartRepository->all(session: $session);

        if ($user !== null)
        {
            $user_cart = null;
            $user_carts = $this->cartRepository->all(user: $user);

            if (count($user_carts) === 0)
            {
                $user_cart = $this->cartFactory->make([
                    'user_id' => $user?->getId(),
                ]);
                $user_cart = $this->cartRepository->insert($user_cart);
            } else {
                $user_cart = $user_carts[0];
            }

            if (count($session_carts) === 1)
            {
                $this->merge($user_cart, $session_carts[0]);
                $merged = true;
            }
        } else if (count($session_carts) === 0 && $create_new)
        {
            $cart = $this->cartFactory->make([
                'session_id' => $session?->getId(),
            ]);
            $this->cartRepository->insert($cart);
        }

        return $merged;
    }

    protected function merge(CartEntity $main,CartEntity $second): void
    {
        foreach($second->getItems() as $cartItem)
        {
            $main->add($cartItem);
        }

        $this->cartRepository->delete($second);
    }

    public function getTotal(CartEntity $cart): MoneyValueObject
    {
        return array_reduce(
            $cart->getItems(),
            fn ($carry, $item) => $carry->add($item->getPrice()),
            MoneyValueObject::fromInt(0)
        );
    }
}
