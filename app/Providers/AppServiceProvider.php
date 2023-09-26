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
            \Domain\Interfaces\CartItemRepository::class,
            \App\Repositories\CartItemDatabaseRepository::class
        );

        $this->app->bind(
            \Domain\Interfaces\CartItemFactory::class,
            \App\Factories\CartItemModelFactory::class
        );

        $this->app
            ->when(\App\Http\Controllers\UpdateCartItemController::class)
            ->needs(\Domain\UseCases\UpdateCartItem\UpdateCartItemInputPort::class)
            ->give(function ($app) {
                return $app->make(\Domain\UseCases\UpdateCartItem\UpdateCartItemInteractor::class, [
                    'output' => $app->make(\App\Adapters\Presenters\UpdateCartItemJsonPresenter::class)
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
