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

class UpsertCartItemTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_can_change_quantity_of_cart_item(): void
    {
        $cart_service = app()->make(CartService::class);

        $response = $this->putJson('/cart/item',[
            'session_id' => 'e558382a-8ced-41ba-82fa-c7090950e524',
            'sku' => 'kirsch_tomaten_samen',
            'quantity' => 5,
            'name' => 'Kirsch-Tomaten Samen',
            'price' => '2,49',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', false)
                    ->where('total', '12,45')
                    ->has('items', 1, fn (AssertableJson $first) => $first
                          ->where('sku', 'kirsch_tomaten_samen')
                          ->where('name', 'Kirsch-Tomaten Samen')
                          ->where('price', '2,49')
                          ->where('quantity', 5)
                    )
                )
            );
    }

    public function test_can_delete_item(): void
    {
        $cart_service = app()->make(CartService::class);

        $response = $this->putJson('/cart/item',[
            'session_id' => 'e558382a-8ced-41ba-82fa-c7090950e524',
            'sku' => 'kirsch_tomaten_samen',
            'quantity' => 0,
            'name' => 'Kirsch-Tomaten Samen',
            'price' => '2,49',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', fn (AssertableJson $json) => $json
                    ->where('merged', false)
                    ->where('total', '0,00')
                    ->has('items', 0)
                )
            );
    }

}
