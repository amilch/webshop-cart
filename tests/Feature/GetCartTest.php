<?php

namespace Tests\Feature;

use App\Models\Cart;
use Domain\Entities\UserEntity;
use Domain\Interfaces\AuthService;
use Domain\Services\CartService;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class GetCartTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_can_get_cart_of_session(): void
    {
        $cart_service = app()->make(CartService::class);

        $response = $this->getJson('/cart?session_id=e558382a-8ced-41ba-82fa-c7090950e524');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', false)
                    ->where('total', '4,98')
                    ->has('items', 1, fn (AssertableJson $first) => $first
                          ->where('sku', 'kirsch_tomaten_samen')
                          ->where('name', 'Kirsch-Tomaten Samen')
                          ->where('price', '2,49')
                          ->where('quantity', 2)
                    )
                )
            );
    }

    public function test_gets_user_cart_and_merges_with_session_cart(): void
    {
        $user = Mockery::mock(UserEntity::class);
        $user->shouldReceive('getId')->andReturn('b888dc8f-8cd2-4728-9e88-280081ec6bed');
        $this->mock(AuthService::class, fn (MockInterface $mock) => $mock
            ->shouldReceive('getCurrentUser')->andReturn($user)
        );

        $cart_service = app()->make(CartService::class);

        $response = $this->getJson('/cart?session_id=e558382a-8ced-41ba-82fa-c7090950e524');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', true)
                    ->where('total', '10,05')
                    ->has('items', 2, fn (AssertableJson $first) => $first
                          ->where('sku', 'kirsch_tomaten_samen')
                          ->where('name', 'Kirsch-Tomaten Samen')
                          ->where('price', '2,49')
                          ->where('quantity', 2)
                    )
                )
            );

        $cart = Cart::where('user_id', 'b888dc8f-8cd2-4728-9e88-280081ec6bed')->first();
        $this->assertNull($cart->getSession());
    }

}
