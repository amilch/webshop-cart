<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\CartItemUpsertedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\UpsertCartItem\UpsertCartItemOutputPort;
use Domain\UseCases\UpsertCartItem\UpsertCartItemResponseModel;

class UpsertCartItemJsonPresenter implements UpsertCartItemOutputPort
{
    public function cartItemUpserted(UpsertCartItemResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new CartItemUpsertedResource($model->getCart(), $model->wasMerged(), $model->getTotal())
        );
    }
}
