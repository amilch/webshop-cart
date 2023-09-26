<?php

namespace Domain\UseCases\UpdateCartItem;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemFactory;
use Domain\Interfaces\CartItemRepository;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartService;

class UpdateCartItemInteractor implements UpdateCartItemInputPort
{
    public function __construct(
        private UpdateCartItemOutputPort $output,
        private CartRepository           $cartRepository,
        private CartItemRepository       $cartItemRepository,
        private CartItemFactory          $cartItemFactory,
        private AuthService              $authService,
        private CartService              $cartService,
    ) {}

    public function updateCartItem(UpdateCartItemRequestModel $request): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = new SessionEntity($request->getSessionId());

        $merged = $this->cartService->mergeCartsOfUserAndSession(session: $session, create_new: true);
        $cart = $this->cartRepository->all(session: $session, user: $user)[0];

        $cartItem = $this->cartItemFactory->make([
            'name' => $request->getName(),
            'sku' => $request->getSku(),
            'price' => $request->getPrice(),
            'quantity' => $request->getQuantity(),
        ]);

        $this->cartItemRepository->upsert($cartItem, $cart);

        return $this->output->cartItemUpdated(
            new UpdateCartItemResponseModel($cart, $merged, $this->cartService->getTotal($cart))
        );
    }
}
