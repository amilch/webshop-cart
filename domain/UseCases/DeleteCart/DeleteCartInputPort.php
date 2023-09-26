<?php

namespace Domain\UseCases\DeleteCart;

use Domain\Interfaces\ViewModel;

interface DeleteCartInputPort
{
    public function deleteCart(DeleteCartRequestModel $request): ViewModel;
}
