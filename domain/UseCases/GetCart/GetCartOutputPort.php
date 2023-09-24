<?php

namespace Domain\UseCases\GetCart;

use Domain\Interfaces\ViewModel;
use Domain\UseCases\GetAllCategories\GetAllCategoriesResponseModel;

interface GetCartOutputPort
{
    public function products(GetCartResponseModel $model): ViewModel;
}
