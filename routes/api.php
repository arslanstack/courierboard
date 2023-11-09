<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Courier\CourierAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\QuoteRequestController as UserRequestController;

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


Route::prefix('auth/user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('homepage-register', [UserAuthController::class, 'homepageregister']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('reset', [UserAuthController::class, 'resetPassword']);
});
Route::prefix('auth/courier')->group(function () {
    Route::post('register', [CourierAuthController::class, 'register']);
    Route::post('login', [CourierAuthController::class, 'login']);
    Route::post('reset', [CourierAuthController::class, 'resetPassword']);
});
Route::prefix('auth/admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('reset', [AdminAuthController::class, 'resetPassword']);
});

Route::middleware(['jwt.auth'])->group(function () {

    Route::group(['prefix' => 'common'], function () {
        // Add common routes here
    });

    Route::group(['prefix' => 'user', 'middleware' => 'assign.guard:users'], function () {
        Route::post('logout', [UserAuthController::class, 'logout']);
        Route::get('refresh', [UserAuthController::class, 'refresh']);
        Route::get('me', [UserAuthController::class, 'me']);


        Route::group(['prefix' => 'request'], function () {
            Route::get('/', [UserRequestController::class, 'index']);
            Route::post('/store', [UserRequestController::class, 'store']);
            Route::get('/{id}', [UserRequestController::class, 'show']);
            Route::post('/update', [UserRequestController::class, 'update']);
            Route::post('/update-address', [UserRequestController::class, 'updateAddress']);
            Route::post('/delete', [UserRequestController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'courier', 'middleware' => 'assign.guard:couriers'], function () {
        Route::post('logout', [CourierAuthController::class, 'logout']);
        Route::get('refresh', [CourierAuthController::class, 'refresh']);
        Route::get('me', [CourierAuthController::class, 'me']);
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'assign.guard:admins'], function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::get('refresh', [AdminAuthController::class, 'refresh']);
        Route::get('me', [AdminAuthController::class, 'me']);
    });
});
