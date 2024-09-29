<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Task Routes
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    // Comment
    Route::get('/tasks/{task_id}/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});
