<?php

namespace App\Http\Resources;

use App\Models\CartItem;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemUpdatedResource extends JsonResource
{
    public function __construct(
        protected CartEntity $cart,
        protected bool $merged,
    ) {}

    public function toArray($request)
    {
        return [
            'merged' => $this->merged,
            'items' => array_map(fn (CartItemEntity $cart_item) => [
                'sku' => $cart_item->getSku(),
                'name' => $cart_item->getName(),
                'price' => $cart_item->getPrice()->toString(),
                'quantity' => $cart_item->getQuantity(),
            ], $this->cart->getItems())
        ];
    }
}
