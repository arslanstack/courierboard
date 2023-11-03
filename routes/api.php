<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserAuthController;

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


Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::prefix('auth')->group(function () {
        Route::post('register', [UserAuthController::class, 'register']);
        Route::post('login', [UserAuthController::class, 'login']);
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::get('refresh', [UserAuthController::class, 'refresh']);
        Route::get('me', [UserAuthController::class, 'me']);
    });
});
