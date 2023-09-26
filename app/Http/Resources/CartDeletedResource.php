<?php

namespace App\Http\Resources;

use App\Models\CartItem;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDeletedResource extends JsonResource
{
    public function __construct( ) {}

    public function toArray($request)
    {
        return [];
    }
}
