<?php

use App\Http\Controllers\Api\VendingMachineController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('vending-machine')->group(function () {
    Route::get('/balance/{id}', [VendingMachineController::class, 'balance']);
    Route::post('/balance/add/{id}', [VendingMachineController::class, 'add']);
    Route::get('/refund/{id}', [VendingMachineController::class, 'refund']);
    Route::post('/select-product/{id}', [VendingMachineController::class, 'select']);
});
