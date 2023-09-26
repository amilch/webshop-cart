<?php

namespace Domain\UseCases\UpsertCartItem;

use Domain\Interfaces\ViewModel;

interface UpsertCartItemInputPort
{
    public function upsertCartItem(UpsertCartItemRequestModel $request): ViewModel;
}
