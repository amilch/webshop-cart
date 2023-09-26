<?php

namespace Domain\UseCases\GetCart;

use Domain\Interfaces\ViewModel;

interface GetCartInputPort
{
    public function getCart(GetCartRequestModel $request): ViewModel;
}
