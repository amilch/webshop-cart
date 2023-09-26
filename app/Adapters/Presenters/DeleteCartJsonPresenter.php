<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\CartDeletedResource;
use App\Http\Resources\CartItemAddedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\AddCartItem\AddCartItemOutputPort;
use Domain\UseCases\AddCartItem\AddCartItemResponseModel;
use Domain\UseCases\DeleteCart\DeleteCartOutputPort;

class DeleteCartJsonPresenter implements DeleteCartOutputPort
{
    public function cartDeleted(): ViewModel
    {
        return new JsonResourceViewModel(
            new CartDeletedResource()
        );
    }
}
