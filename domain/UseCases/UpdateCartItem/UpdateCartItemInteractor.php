<?php

namespace Domain\UseCases\UpdateCartItem;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemFactory;
use Domain\Interfaces\CartItemRepository;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\SessionService;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartManipulationService;

class UpdateCartItemInteractor implements UpdateCartItemInputPort
{
    public function __construct(
        private UpdateCartItemOutputPort $output,
        private CartRepository           $cartRepository,
        private CartFactory              $cartFactory,
        private CartItemRepository       $cartItemRepository,
        private CartItemFactory          $cartItemFactory,
        private SessionService           $sessionService,
        private AuthService              $authService,
        private CartManipulationService  $cartManipulationService,
    ) {}

    public function updateCartItem(UpdateCartItemRequestModel $request): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = $this->sessionService->getSession();

        $merged = $this->cartManipulationService->mergeCartsOfUserAndSession(create_new: true);
        $cart = $this->cartRepository->all(session: $session, user: $user)[0];

        $cartItem = $this->cartItemFactory->make([
            'name' => $request->getName(),
            'sku' => $request->getSku(),
            'price' => $request->getPrice(),
            'quantity' => $request->getQuantity(),
        ]);

        $this->cartItemRepository->upsert($cartItem, $cart);

        return $this->output->cartItemUpdated(
            new UpdateCartItemResponseModel($cart, $merged)
        );
    }
}
