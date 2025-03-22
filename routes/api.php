<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DefaultController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\Api\TaskController;
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


Route::group(['namespace' => 'App\Api\v1\Controllers'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('users', ['uses' => 'UserController@index']);
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::get('/clients', [ClientController::class, 'data']);
Route::get('/projects', [ProjetController::class, 'data']);
Route::get('/tasks', [TaskController::class, 'data']);
Route::get('/offers', [OfferController::class, 'data']);
Route::get('/invoices', [InvoiceController::class, 'data']);
Route::get('/payments', [PaymentController::class, 'data']);

