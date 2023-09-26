<?php

namespace Domain\UseCases\DeleteCart;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemFactory;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartService;

class DeleteCartInteractor implements DeleteCartInputPort
{
    public function __construct(
        private DeleteCartOutputPort $output,
        private CartRepository       $cartRepository,
        private AuthService          $authService,
        private CartService          $cartService,
    ) {}

    public function deleteCart(DeleteCartRequestModel $request): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = new SessionEntity($request->getSessionId());

        $this->cartService->mergeCartsOfUserAndSession(session: $session);

        $carts = $this->cartRepository->all(session: $session, user: $user);

        if (sizeof($carts) == 1)
        {
            $carts[0]->remove();
        }

        return $this->output->cartDeleted();
    }
}
