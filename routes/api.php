<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\CategoryController;

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

// Authentication routes
Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


// Global Authentication for API routes
Route::middleware('auth:sanctum')->group(function () { 

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Admin-only routes
    Route::middleware('CheckRole:admin')->group(function() {
        // Routes accessible only by admins (e.g., POST /books, PUT /books/{id}, DELETE /books/{id} )
        // books API routes
        Route::resource('books', BookController::class)->except(['create', 'edit']);
        // author API routes
        Route::resource('authors', AuthorController::class)->except(['create', 'edit']);
        Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
        Route::get('/borrowings', [BorrowingController::class, 'index']);
        Route::get('/borrowings/{id}', [BorrowingController::class, 'show']);
        Route::post('/borrowings', [BorrowingController::class, 'store']);
        Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnBook']);
    });
});
