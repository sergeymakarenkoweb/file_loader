<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InstagramController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {
    Route::prefix('/instagram')->group(function() {
        Route::get('/media', [InstagramController::class, 'getMedia']);
        Route::get('/refresh', [InstagramController::class, 'refreshMedia']);
    });
    Route::prefix('/contact')->group(function () {
        Route::post('/', [ContactController::class, 'add']);
    });
});
