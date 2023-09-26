<?php

namespace Domain\UseCases\AddCartItem;

use Domain\Interfaces\ViewModel;

interface AddCartItemOutputPort
{
    public function cartItemAdded(AddCartItemResponseModel $model): ViewModel;
}
