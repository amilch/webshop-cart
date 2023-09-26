<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\UpsertCartItemRequest;
use Domain\UseCases\AddCartItem\AddCartItemInputPort;
use Domain\UseCases\AddCartItem\AddCartItemRequestModel;
use Domain\UseCases\AddCartItem\AddCartItemResponseModel;
use Domain\UseCases\UpsertCartItem\UpsertCartItemInputPort;
use Domain\UseCases\UpsertCartItem\UpsertCartItemRequestModel;

class AddCartItemController extends Controller
{
    public function __construct(
        private AddCartItemInputPort $interactor,
    ) {}

    public function __invoke(AddCartItemRequest $request)
    {
        $viewModel = $this->interactor->addCartItem(
            new AddCartItemRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
