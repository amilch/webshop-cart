<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\CartItemUpdatedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\UpdateCartItem\UpdateCartItemOutputPort;
use Domain\UseCases\UpdateCartItem\UpdateCartItemResponseModel;

class UpdateCartItemJsonPresenter implements UpdateCartItemOutputPort
{
    public function cartItemUpdated(UpdateCartItemResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new CartItemUpdatedResource($model->getCart(), $model->wasMerged())
        );
    }
}
