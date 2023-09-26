<?php

namespace Domain\UseCases\UpsertCartItem;

use Domain\Interfaces\ViewModel;

interface UpsertCartItemOutputPort
{
    public function cartItemUpserted(UpsertCartItemResponseModel $model): ViewModel;
}
