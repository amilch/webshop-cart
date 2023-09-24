<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\UpdateCartItemRequest;
use Domain\UseCases\UpdateCartItem\UpdateCartItemInputPort;
use Domain\UseCases\UpdateCartItem\UpdateCartItemRequestModel;

class UpdateCartItemController extends Controller
{
    public function __construct(
        private UpdateCartItemInputPort $interactor,
    ) {}

    public function __invoke(UpdateCartItemRequest $request)
    {
        $viewModel = $this->interactor->updateCartItem(
            new UpdateCartItemRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
