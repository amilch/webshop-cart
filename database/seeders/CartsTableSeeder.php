<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::create([
            'session_id' => 'e558382a-8ced-41ba-82fa-c7090950e524',
        ]);

        Cart::create([
            'user_id' => 'b888dc8f-8cd2-4728-9e88-280081ec6bed',
        ]);
    }
}
