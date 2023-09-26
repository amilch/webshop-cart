<?php

namespace Domain\UseCases\GetCart;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartService;

class GetCartInteractor implements GetCartInputPort
{
    public function __construct(
        private GetCartOutputPort $output,
        private CartRepository    $repository,
        private AuthService       $authService,
        private CartService       $cartService,
    ) {}

    public function getCart(GetCartRequestModel $request): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = new SessionEntity($request->getSessionId());

        $merged = $this->cartService->mergeCartsOfUserAndSession(session: $session, create_new: false);
        $carts = $this->repository->all(session: $session, user: $user);
        $cart = count($carts) === 1 ? $carts[0] : null;

        return $this->output->products(
            new GetCartResponseModel($cart, $merged,
                $cart !== null ? $this->cartService->getTotal($cart) : null)
        );
    }
}
