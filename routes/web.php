<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TelegramController;

use App\Events\HelloEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/check-server', [TelegramController::class, 'checkServer']);

Route::get('/', function () {
    return view('welcome');
});


// Teletegram
Route::get('/contact', [TelegramController::class, 'index']);
Route::get('/activity', [TelegramController::class, 'getActivity']);
Route::match(['get', 'post'],'/send-message', [TelegramController::class, 'sendMessage']);
//

// web-socket
Route::get('/hi', function(){
    return view('chat');
});

Route::get('/send-msg', function() {
    event(new HelloEvent());

    return "oke";
});

//