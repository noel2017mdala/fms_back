<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\loginController;
use App\Http\Controllers\Api\Dashboard;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Api\TransactionController;

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

Route::post('register', [loginController::class, 'register']);
// Route::post('login',[AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);
Route::post('login',[loginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    // Route::get('dashboard', [Dashboard::class, 'index']);
    Route::get('transaction', [TransactionController::class, 'index']);
    Route::get('earnings', [TransactionController::class, 'getEarnings']);
    Route::get('expences', [TransactionController::class, 'getExpenses']);
});

    