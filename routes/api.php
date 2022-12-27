<?php

use Illuminate\Support\Facades\Route;

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

Route::post('login', [App\Http\Controllers\UserController::class, 'show']);
Route::post('register', [App\Http\Controllers\UserController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('post', [App\Http\Controllers\PostController::class, 'index']);
    Route::post('post', [App\Http\Controllers\PostController::class, 'store']); 
    Route::get('category', [App\Http\Controllers\CategoryController::class, 'index']);
});
Route::get('city', [App\Http\Controllers\CityController::class, 'index']);
Route::get('weather', [App\Http\Controllers\WeatherController::class, 'index']);

