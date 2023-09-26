<?php

namespace Domain\UseCases\AddCartItem;

use Domain\Interfaces\ViewModel;

interface AddCartItemInputPort
{
    public function addCartItem(AddCartItemRequestModel $request): ViewModel;
}
