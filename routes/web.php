<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TelegramController;

use Illuminate\Http\Request;

use App\Events\HelloEvent;

use Illuminate\Support\Facades\Auth;

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

Route::get('/users', function(){
    return view('users.index');
})->name('users');

Route::get('/login/{id}', function($id){
    Auth::loginUsingId($id);

    return redirect()->route('chat');
})->name('login');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', function(){
        Auth::logout();
    
        return redirect('users');
    })->name('logout');
    
    Route::get('/chat-p2p', function(){
        return view('chat');
    })->name("chat");

});


Route::get('/ws', function() {
    return view('websocket');
});


Route::post('/chat-message', function(Request $request) {
    event(new HelloEvent($request->message));
    return null;
});
//