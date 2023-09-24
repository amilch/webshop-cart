<?php

namespace Domain\UseCases\GetCart;

use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\SessionService;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartManipulationService;

class GetCartInteractor implements GetCartInputPort
{
    public function __construct(
        private GetCartOutputPort        $output,
        private CartRepository           $repository,
        private SessionService           $sessionService,
        private AuthService              $authService,
        private CartManipulationService  $cartManipulationService,
    ) {}

    public function getCart(): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = $this->sessionService->getSession();

        $merged = $this->cartManipulationService->mergeCartsOfUserAndSession(create_new: false);
        $carts = $this->repository->all(session: $session, user: $user);
        $cart = count($carts) === 1 ? $carts[0] : null;

        return $this->output->products(
            new GetCartResponseModel($cart, $merged)
        );
    }
}
