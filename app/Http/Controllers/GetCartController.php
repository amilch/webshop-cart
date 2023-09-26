<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\GetC;
use App\Http\Requests\GetCartRequest;
use Domain\UseCases\GetAllCategories\GetAllCategoriesInputPort;
use Domain\UseCases\GetCart\GetCartInputPort;
use Domain\UseCases\GetCart\GetCartRequestModel;
use Domain\UseCases\GetCart\GetProductsRequestModel;

class GetCartController extends Controller
{
    public function __construct(
        private GetCartInputPort $interactor,
    ) {}

    public function __invoke(GetCartRequest $request)
    {
        $viewModel = $this->interactor->getCart(
            new GetCartRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }

}
