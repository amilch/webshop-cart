<?php

namespace Domain\Services;

use App\Services\SessionService;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemRepository;
use Domain\Interfaces\CartRepository;

class CartManipulationService
{
    public function __construct(
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository,
        private AuthService $authService,
        private SessionService $sessionService,
        private CartFactory $cartFactory,
    ) {}

    public function mergeCartsOfUserAndSession(bool $create_new = false): bool
    {
        $user = $this->authService->getCurrentUser();
        $session = $this->sessionService->getSession();
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

    public function merge(CartEntity $main,CartEntity $second): void
    {
        foreach($second->getItems() as $cartItem)
        {
            $this->cartItemRepository->upsert($cartItem, $main);
        }

        $this->cartRepository->delete($second);
    }
}
