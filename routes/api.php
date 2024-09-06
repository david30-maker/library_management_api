<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

//Books
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::post('books', [BookController::class, 'store']);
Route::put('books/{id}', [BookController::class, 'update']);
Route::delete('books/{id}', [BookController::class, 'destroy']);
Routes::post('books/{id}/borrow', [BookController::class, 'borrow']);
Routes::post('books/{id}/return', [BookController::class, 'returnBook']);

//Authors
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{id}', [AuthorController::class, 'show']);
Route::post('authors', [AuthorController::class, 'store']);
Route::put('authors/{id}', [AuthorController::class, 'update']);
Route::delete('authors/{id}', [AuthorController::class, 'destroy']);

//Users
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
// Route::post('users', [UserController::class, 'store']);
Routes::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

//Authentification
Route::post('login', [AuthController::class, 'login']);

//Borrow Records
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/borrow-records', [BorrowRecordController::class, 'index']);
    Route::get('/borrow-records/{id}', [BorrowRecordController::class, 'show']);
});
