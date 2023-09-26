<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\UpsertCartItemRequest;
use Domain\UseCases\UpsertCartItem\UpsertCartItemInputPort;
use Domain\UseCases\UpsertCartItem\UpsertCartItemRequestModel;

class UpsertCartItemController extends Controller
{
    public function __construct(
        private UpsertCartItemInputPort $interactor,
    ) {}

    public function __invoke(UpsertCartItemRequest $request)
    {
        $viewModel = $this->interactor->upsertCartItem(
            new UpsertCartItemRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
