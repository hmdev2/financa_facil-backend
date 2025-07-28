<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/dashboard', [TransactionsController::class, 'show']);
Route::post('/transaction/store', [TransactionsController::class, 'store']);
Route::delete('transaction/{id}', [TransactionsController::class, 'destroy']);
Route::put('transaction/{id}', [TransactionsController::class, 'update']);
Route::get('transaction/{id}', [TransactionsController::class, 'transaction']);
