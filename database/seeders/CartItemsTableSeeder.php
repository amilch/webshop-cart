<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CartItem::create([
            'cart_id' =>
                Cart::where('session_id', 'e558382a-8ced-41ba-82fa-c7090950e524')
                    ->first()->id,
            'name' => 'Kirsch-Tomaten Samen',
            'sku' => 'kirsch_tomaten_samen',
            'price' => 249,
            'quantity' => 2,
        ]);

        CartItem::create([
            'cart_id' =>
                Cart::where('user_id', 'b888dc8f-8cd2-4728-9e88-280081ec6bed')
                    ->first()->id,
            'name' => 'Basilikum Samen',
            'sku' => 'basilikum_samen',
            'price' => 169,
            'quantity' => 3,
        ]);

    }
}
