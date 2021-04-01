<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\loginController;
use App\Http\Controllers\Api\Dashboard;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\Projects;
use App\Http\Controllers\Api\projectsTransaction as Transaction;
use App\Http\Controllers\Api\AmountController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [loginController::class, 'register']);
// Route::post('login',[AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);
Route::post('login',[loginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    
    //Activity transaction
    Route::post('createtransaction', [TransactionController::class, 'createTransaction']);
    Route::get('earnings/{id?}', [TransactionController::class, 'getEarnings']);
    Route::get('expences/{id?}', [TransactionController::class, 'getExpenses']);
    Route::get('transaction/{param?}/{id?}', [TransactionController::class, 'index']);
    Route::get('earnings/{id?}', [TransactionController::class, 'getEarnings']);
    Route::post('deletetransaction', [TransactionController::class, 'deleteTransaction']);    
});


Route::middleware('auth:api')->group(function (){

        // projects routes
    Route::post('createproject', [Projects::class, 'createProject']);
    Route::get('projects', [Projects::class, 'index']);
    Route::get('viewprojects/{id?}', [Projects::class, 'listProjects']);
    Route::post('deleteproject', [Projects::class, 'deleteProject']);
});


// User amount middleware
Route::middleware(['auth:api'])->group(function () {

    Route::get('getamountbalance/{id?}', [AmountController::class, 'index']);
    Route::get('getAmount/{id?}', [AmountController::class, 'getAmountTransaction']);
});

Route::post('createamount', [AmountController::class, 'create_transaction']);


// Route::get('getamount', [AmountController::class, 'getAmount']);

// Route::get('', [Transaction::class, 'createTransaction']);
// Route::get('transactions', [Transaction::class, 'index']);
// Route::get('projecttransactions', [Projects::class, 'projectTransactions']);

// Route::post('user',[loginController::class, 'index']);
