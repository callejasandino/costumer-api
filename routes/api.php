<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomersController;
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

Route::prefix('auth')->controller(AuthController::class)->group(function ($router) {
    $router->post('login', 'login');
    $router->post('register', 'register');
    $router->middleware('auth:api')->group(function ($router) {
        $router->post('logout', 'logout');
        $router->get('validateToken', 'validateToken');
    });
});

Route::prefix('customers')->controller(CustomersController::class)->middleware('auth:api')->group(function ($router) {
    $router->get('index', 'index');
    $router->post('store', 'store');
    $router->put('update/{customerId}', 'update');
    $router->delete('destroy/{customerId}', 'destroy');
});
