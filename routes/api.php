<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/cart', '\App\Http\Controllers\GetCartController');
Route::put('/cart/item', '\App\Http\Controllers\UpsertCartItemController');
Route::post('/cart/item', '\App\Http\Controllers\AddCartItemController');

Route::group(['middleware' => ['auth:api', 'can:admin']], function() {

});

