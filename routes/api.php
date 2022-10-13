<?php

use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TokenController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/p-login', 'providerLogin');
    Route::post('/c-register', 'customerRegister');
    Route::post('/c-login', 'customerLogin');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('app', AppController::class);

    Route::middleware('application')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('token', TokenController::class)->except('show', 'update');
        Route::apiResource('customer', CustomerController::class)->except('store');

        Route::apiResources([
            'category' => CategoryController::class,
            'provider' => ProviderController::class,
            'service' => ServiceController::class,
            'appointment' => AppointmentController::class,
        ]);
        Route::get('/provider-appointments', [ProviderController::class, 'appointments'])->middleware('abilities:provider:*');
    });
});
