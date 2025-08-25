<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/dashboard', [TransactionsController::class, 'show']);
    Route::post('/transaction/store', [TransactionsController::class, 'store']);
    Route::delete('transaction/{id}', [TransactionsController::class, 'destroy']);
    Route::put('transaction/{id}', [TransactionsController::class, 'update']);
    Route::get('transaction/{id}', [TransactionsController::class, 'transaction']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/validate-token', function (Request $request) {
        return response()->json(['valid' => true]);
    });
});
