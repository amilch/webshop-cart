<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Requests\UpsertCartItemRequest;
use Domain\UseCases\AddCartItem\AddCartItemInputPort;
use Domain\UseCases\AddCartItem\AddCartItemRequestModel;
use Domain\UseCases\AddCartItem\AddCartItemResponseModel;
use Domain\UseCases\DeleteCart\DeleteCartInputPort;
use Domain\UseCases\DeleteCart\DeleteCartRequestModel;
use Domain\UseCases\UpsertCartItem\UpsertCartItemInputPort;
use Domain\UseCases\UpsertCartItem\UpsertCartItemRequestModel;

class DeleteCartController extends Controller
{
    public function __construct(
        private DeleteCartInputPort $interactor,
    ) {}

    public function __invoke(DeleteCartRequest $request)
    {
        $viewModel = $this->interactor->deleteCart(
            new DeleteCartRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
