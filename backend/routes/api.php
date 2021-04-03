<?php

use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\BudgetItemController;
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

Route::group(['prefix' => 'budget'], function () {
    Route::get('/', [BudgetController::class, 'index']);
    Route::post('/', [BudgetController::class, 'post']);
    Route::get('/{id}', [BudgetController::class, 'detail']);
});

Route::group(['prefix' => 'budget-items'], function () {
    Route::post('/', [BudgetItemController::class, 'post']);
});
