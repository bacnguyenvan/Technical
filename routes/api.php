<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload-files', [FileController::class, 'upload']);

Route::post('/upload-chunk', [FileController::class, 'uploadChunk']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/messages', [ChatController::class, 'sendMessage']);
    Route::get('/messages', [ChatController::class, 'getMessages']);
});


Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');