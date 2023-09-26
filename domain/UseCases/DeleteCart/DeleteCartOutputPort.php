<?php

namespace Domain\UseCases\DeleteCart;

use Domain\Interfaces\ViewModel;

interface DeleteCartOutputPort
{
    public function cartDeleted(): ViewModel;
}
