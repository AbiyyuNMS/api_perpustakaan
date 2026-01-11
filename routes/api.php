<?php

use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\ActivityLogController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/category', [BookController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/categories', CategoryController::class);

    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::get('/loans', [LoanController::class, 'index']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::put('/loans/{id}', [LoanController::class, 'update']);
    Route::get('/logs', [ActivityLogController::class, 'index']);
});
