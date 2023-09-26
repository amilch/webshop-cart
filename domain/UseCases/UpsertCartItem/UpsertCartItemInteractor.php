<?php

namespace Domain\UseCases\UpsertCartItem;

use Domain\Entities\SessionEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemFactory;
use Domain\Interfaces\CartRepository;
use Domain\Interfaces\ViewModel;
use Domain\Services\CartService;

class UpsertCartItemInteractor implements UpsertCartItemInputPort
{
    public function __construct(
        private UpsertCartItemOutputPort $output,
        private CartRepository           $cartRepository,
        private CartItemFactory          $cartItemFactory,
        private AuthService              $authService,
        private CartService              $cartService,
    ) {}

    public function upsertCartItem(UpsertCartItemRequestModel $request): ViewModel
    {
        $user = $this->authService->getCurrentUser();
        $session = new SessionEntity($request->getSessionId());

        $merged = $this->cartService->mergeCartsOfUserAndSession(session: $session, create_new: true);
        $cart = $this->cartRepository->all(session: $session, user: $user)[0];

        if ($request->getQuantity() == 0)
        {
            $cart->getWithSku($request->getSku())->removeItem();
        } else {
            $cartItem = $cart->getWithSku($request->getSku());

            if ($cartItem !== null)
            {
                $cartItem->setQuantity($request->getQuantity());
            } else {
                $newCartItem = $this->cartItemFactory->make([
                    'name' => $request->getName(),
                    'sku' => $request->getSku(),
                    'price' => $request->getPrice(),
                    'quantity' => $request->getQuantity(),
                ]);

               $cart->add($newCartItem);
            }
        }

        return $this->output->cartItemUpserted(
            new UpsertCartItemResponseModel($cart, $merged, $this->cartService->getTotal($cart))
        );
    }
}
