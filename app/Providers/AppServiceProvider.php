<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Domain\Interfaces\CartRepository::class,
            \App\Repositories\CartDatabaseRepository::class
        );

        $this->app->bind(
            \Domain\Interfaces\CartFactory::class,
            \App\Factories\CartModelFactory::class
        );

        $this->app->bind(
            \Domain\Interfaces\CartItemFactory::class,
            \App\Factories\CartItemModelFactory::class
        );

        $this->app
            ->when(\App\Http\Controllers\UpsertCartItemController::class)
            ->needs(\Domain\UseCases\UpsertCartItem\UpsertCartItemInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\UpsertCartItem\UpsertCartItemInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UpsertCartItemJsonPresenter::class)
                ]);
            });

        $this->app->bind(
            \Domain\Interfaces\AuthService::class,
            \App\Services\KeycloakAuthService::class
        );

        $this->app
            ->when(\App\Http\Controllers\GetCartController::class)
            ->needs(\Domain\UseCases\GetCart\GetCartInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\GetCart\GetCartInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\GetCartJsonPresenter::class)
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\AddCartItemController::class)
            ->needs(\Domain\UseCases\AddCartItem\AddCartItemInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\AddCartItem\AddCartItemInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\AddCartItemJsonPresenter::class)
                ]);
            });

        $this->app
            ->when(\App\Http\Controllers\DeleteCartController::class)
            ->needs(\Domain\UseCases\DeleteCart\DeleteCartInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\DeleteCart\DeleteCartInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\DeleteCartJsonPresenter::class)
                ]);
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
