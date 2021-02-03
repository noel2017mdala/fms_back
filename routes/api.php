<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\loginController;
use App\Http\Controllers\Api\Dashboard;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\Projects;
use App\Http\Controllers\Api\projectsTransaction as Transaction;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [loginController::class, 'register']);
// Route::post('login',[AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);
Route::post('login',[loginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    // Route::get('dashboard', [Dashboard::class, 'index']);
    
    Route::post('createtransaction', [TransactionController::class, 'createTransaction']);
    Route::get('earnings/{id?}', [TransactionController::class, 'getEarnings']);
    Route::get('expences/{id?}', [TransactionController::class, 'getExpenses']);
    Route::get('transaction/{param?}/{id?}', [TransactionController::class, 'index']);
    Route::get('earnings/{id?}', [TransactionController::class, 'getEarnings']);
    Route::get('deletetransaction/{user?}/{id?}', [TransactionController::class, 'deleteTransaction']);

    // projects routes
    Route::post('createproject', [Projects::class, 'createProject']);
});

Route::middleware('auth:api')->group(function (){
    Route::get('projects', [Projects::class, 'index']);
});



// Route::get('', [Transaction::class, 'createTransaction']);
// Route::get('transactions', [Transaction::class, 'index']);
// Route::get('projecttransactions', [Projects::class, 'projectTransactions']);

Route::post('user',[loginController::class, 'index']);
