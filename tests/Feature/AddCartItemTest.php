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

class AddCartItemTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_can_add_item_to_new_session_cart(): void
    {
        $cart_service = app()->make(CartService::class);

        $response = $this->postJson('/cart/item',[
            'name' => 'Kirsch-Tomaten Samen',
            'sku' => 'kirsch_tomaten_samen',
            'price' => 249,
            'quantity' => 1,
            'session_id' => 'random',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', false)
                    ->where('total', '2,49')
                    ->has('items', 1, fn (AssertableJson $first) => $first
                          ->where('sku', 'kirsch_tomaten_samen')
                          ->where('name', 'Kirsch-Tomaten Samen')
                          ->where('price', '2,49')
                          ->where('quantity', 1)
                    )
                )
            );

        $cart = Cart::where('session_id', 'random')->first();
        $this->assertEquals(MoneyValueObject::fromInt(249), $cart_service->getTotal($cart));
        $this->assertEquals(1, sizeof($cart->getItems()));
    }

    public function test_can_add_item_to_new_user_cart(): void
    {
        $user = Mockery::mock(UserEntity::class);
        $user->shouldReceive('getId')->andReturn('random');
        $this->mock(AuthService::class, fn (MockInterface $mock) => $mock
            ->shouldReceive('getCurrentUser')->andReturn($user)
        );

        $cart_service = app()->make(CartService::class);

        $response = $this->postJson('/cart/item',[
            'name' => 'Kirsch-Tomaten Samen',
            'sku' => 'kirsch_tomaten_samen',
            'price' => 249,
            'quantity' => 1,
            'session_id' => 'random2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', false)
                    ->where('total', '2,49')
                    ->has('items', 1, fn (AssertableJson $first) => $first
                          ->where('sku', 'kirsch_tomaten_samen')
                          ->where('name', 'Kirsch-Tomaten Samen')
                          ->where('price', '2,49')
                          ->where('quantity', 1)
                    )
                )
            );

        $cart = Cart::where('user_id', 'random')->first();
        $this->assertEquals(MoneyValueObject::fromInt(249), $cart_service->getTotal($cart));
        $this->assertEquals(1, sizeof($cart->getItems()));
        $this->assertNull($cart->getSession());
    }

    public function test_adding_same_item_twice_increases_quantity(): void
    {
        $response = $this->postJson('/cart/item',[
            'name' => 'Kirsch-Tomaten Samen',
            'sku' => 'kirsch_tomaten_samen',
            'price' => 249,
            'quantity' => 1,
            'session_id' => 'random',
        ]);

        $response2 = $this->postJson('/cart/item',[
            'name' => 'Kirsch-Tomaten Samen',
            'sku' => 'kirsch_tomaten_samen',
            'price' => 249,
            'quantity' => 1,
            'session_id' => 'random',
        ]);

        $response2
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
}
