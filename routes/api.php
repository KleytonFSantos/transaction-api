<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\TransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::controller(TransactionController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/transactions', 'index');
    Route::get('/transaction/{transaction}', 'show');
    Route::get('/transactions/{type}', 'filterByType');
    Route::post('/add-transaction', 'store');
    Route::patch('/update-transaction/{transaction}', 'update');
    Route::delete('/delete-transaction/{transaction}', 'destroy');
});
