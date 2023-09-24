<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\GetC;
use Domain\UseCases\GetAllCategories\GetAllCategoriesInputPort;
use Domain\UseCases\GetCart\GetCartInputPort;
use Domain\UseCases\GetCart\GetProductsRequestModel;

class GetCartController extends Controller
{
    public function __construct(
        private GetCartInputPort $interactor,
    ) {}

    public function __invoke()
    {
        $viewModel = $this->interactor->getCart();

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }

}
