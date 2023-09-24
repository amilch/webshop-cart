<?php

namespace Domain\UseCases\UpdateCartItem;

use Domain\Interfaces\ViewModel;

interface UpdateCartItemOutputPort
{
    public function cartItemUpdated(UpdateCartItemResponseModel $model): ViewModel;
}
