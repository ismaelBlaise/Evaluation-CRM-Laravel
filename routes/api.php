<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DefaultController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceLineController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProjetController;
use App\Http\Controllers\Api\StatusController;
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

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'data']);
    Route::get('/nb', [ClientController::class, 'nbdata']);
});

// Project Routes
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjetController::class, 'data']);
    Route::get('/nb', [ProjetController::class, 'nbdata']);
    Route::get('/chart', [ProjetController::class, 'getProjectCountByStatus']);  
});

// Task Routes
Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'data']);
    Route::get('/nb', [TaskController::class, 'nbdata']);
});

// Offer Routes
Route::prefix('offers')->group(function () {
    Route::get('/', [OfferController::class, 'data']);
    Route::get('/nb', [OfferController::class, 'nbdata']);
});

// Invoice Routes
Route::prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'data']);
    Route::get('/nb', [InvoiceController::class, 'nbdata']);
});

// Payment Routes
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'data']);
    Route::get('/nb', [PaymentController::class, 'nbdata']);
    Route::get('/sum', [PaymentController::class, 'sumpayment']);
    Route::get('/chart', [PaymentController::class,'monthlyRevenueChart']);
});

// Invoice Line Routes
Route::prefix('invoice-lines')->group(function () {
    Route::get('/', [InvoiceLineController::class, 'data']);
    Route::get('/nb', [InvoiceLineController::class, 'nbdata']);
});

Route::prefix('status')->group(function () {
    Route::get('/', [StatusController::class, 'data']);
    
});

