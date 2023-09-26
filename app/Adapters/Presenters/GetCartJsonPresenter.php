<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\CartResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\GetCart\GetCartOutputPort;
use Domain\UseCases\GetCart\GetCartResponseModel;

class GetCartJsonPresenter implements GetCartOutputPort
{
    public function products(GetCartResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new CartResource($model->getCart(), $model->wasMerged(), $model->getTotal())
        );
    }
}
