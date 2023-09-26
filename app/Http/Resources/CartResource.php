<?php

namespace App\Http\Resources;

use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function __construct(
        protected ?CartEntity $cart,
        protected bool $merged,
        protected ?MoneyValueObject $total,
    ) {}

    public function toArray($request)
    {
        return [
            'merged' => $this->merged,
            'total' => $this->total?->toString(),
            'items' => array_map(fn (CartItemEntity $cart_item) => [
                'sku' => $cart_item->getSku(),
                'name' => $cart_item->getName(),
                'price' => $cart_item->getPrice()->toString(),
                'quantity' => $cart_item->getQuantity(),
            ], $this->cart?->getItems() ?? [])
        ];
    }
}
