<?php

namespace Tests\Unit;

use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;
use Domain\Interfaces\AuthService;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartFactory;
use Domain\Interfaces\CartItemEntity;
use Domain\Interfaces\CartRepository;
use Domain\Services\CartService;
use Domain\ValueObjects\MoneyValueObject;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_total_should_be_zero_for_empty_cart(): void
    {
        $cart_repository = Mockery::mock(CartRepository::class);
        $auth_service = Mockery::mock(AuthService::class);
        $cart_factory = Mockery::mock(CartFactory::class);
        $cart = Mockery::mock(CartEntity::class);
        $cart->shouldReceive('getItems')->once()->andReturn([]);

        $cart_service = new CartService(
            $cart_repository,
            $auth_service,
            $cart_factory,
        );
        $this->assertEquals(
            MoneyValueObject::fromInt(0),
            $cart_service->getTotal($cart)
            );
    }

    public function test_total_should_be_correct_sum_for_multiple_items_and_quantities(): void
    {
        $cart_repository = Mockery::mock(CartRepository::class);
        $auth_service = Mockery::mock(AuthService::class);
        $cart_factory = Mockery::mock(CartFactory::class);

        $cart = Mockery::mock(CartEntity::class);

        $item1 = Mockery::mock(CartItemEntity::class);
        $item1->shouldReceive('getPrice')->andReturn(MoneyValueObject::fromInt(100));
        $item1->shouldReceive('getQuantity')->andReturn(2);
        $item2 = Mockery::mock(CartItemEntity::class);
        $item2->shouldReceive('getPrice')->andReturn(MoneyValueObject::fromInt(300));
        $item2->shouldReceive('getQuantity')->andReturn(4);

        $cart->shouldReceive('getItems')->once()->andReturn([$item1, $item2]);

        $cart_service = new CartService(
            $cart_repository,
            $auth_service,
            $cart_factory,
        );
        $this->assertEquals(
            MoneyValueObject::fromInt(100*2+300*4),
            $cart_service->getTotal($cart)
            );
    }

    public function test_merge_should_move_all_items_into_first_cart_and_delete_second(): void
    {
        $cart1 = Mockery::mock(CartEntity::class);
        $cart2 = Mockery::mock(CartEntity::class);

        $item1 = Mockery::mock(CartItemEntity::class);
        $item2 = Mockery::mock(CartItemEntity::class);
        $item3 = Mockery::mock(CartItemEntity::class);

        $cart1->shouldReceive('getItems')->andReturn([$item1, $item2]);
        $cart1->shouldReceive('add')->with($item3)->once();
        $cart2->shouldReceive('getItems')->andReturn([$item3]);

        $cart_repository = Mockery::mock(CartRepository::class);
        $cart_repository->shouldReceive('delete')->once()->with($cart2);
        $auth_service = Mockery::mock(AuthService::class);
        $cart_factory = Mockery::mock(CartFactory::class);

        $cart_service = new CartService(
            $cart_repository,
            $auth_service,
            $cart_factory,
        );

        $cart_service->merge($cart1, $cart2);
    }

}
