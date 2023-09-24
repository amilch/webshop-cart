<?php

namespace Domain\UseCases\UpdateCartItem;

use Domain\Interfaces\ViewModel;

interface UpdateCartItemInputPort
{
    public function updateCartItem(UpdateCartItemRequestModel $request): ViewModel;
}
