<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\CartItemAddedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\AddCartItem\AddCartItemOutputPort;
use Domain\UseCases\AddCartItem\AddCartItemResponseModel;

class AddCartItemJsonPresenter implements AddCartItemOutputPort
{
    public function cartItemAdded(AddCartItemResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new CartItemAddedResource($model->getCart(), $model->wasMerged(), $model->getTotal())
        );
    }
}
