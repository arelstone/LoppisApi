<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('auction-houses', 'AuctionHouseController');
Route::get('auction-houses/{auction_house}/logo', 'LogoController@show');
Route::post('auction-houses/{auction_house}/logo', 'LogoController@store');
Route::resource('auction-houses/{auction_house}/reviews', 'ReviewsController')->only(['index', 'store']);
Route::resource('users', 'UserController')->only(['show']);
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
