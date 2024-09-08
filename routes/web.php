<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;

use App\Events\HelloEvent;
use App\Http\Controllers\ChatController;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ArrayHelpers;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index']);

// payment with EPSILON 
Route::match(['get', 'post'],'/payment/epsilon', [HomeController::class, 'epsilon'])->name('payment-epsilon');


// Teletegram
Route::get('/contact', [TelegramController::class, 'index']);
Route::get('/activity', [TelegramController::class, 'getActivity']);
Route::match(['get', 'post'],'/send-message', [TelegramController::class, 'sendMessage']);
//

// Home
Route::get('/videos', [HomeController::class, 'videos']);

// web-socket

Route::get('/users', function(){
    return view('users.index');
})->name('users');

Route::get('/login/{id}', function($id){
    Auth::loginUsingId($id);

    return redirect()->route('converstation');
})->name('login');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', function(){
        Auth::logout();
    
        return redirect('users');
    })->name('logout');
    
    Route::get('/chat-p2p', [ChatController::class, 'index'])->name("converstation");

});


Route::get('/ws', function() {
    return view('websocket');
});

// architect
Route::get('/binding-injection', [HomeController::class, 'testOne']);

// handle inventory
// update quantity when order success
Route::get('/inventory', [InventoryController::class, 'handle'])->middleware('json.response');

# action

Route::post('/chat-message', [ChatController::class, 'chat'])->name("chat");
//


Route::get('/import-data', function () {
    // ini_set("memory_limit", "2048M");
    // ini_set("max_execution_time", 100);

    $csvPath = storage_path('app\customers.csv');

    // $file = fopen($csvPath, 'r');

    // $generateRow = function($row) {
    //    return [
    //         "customer_id"   => $row[1], 
    //         "first_name"    => $row[2], 
    //         "last_name"     => $row[3], 
    //         "company"       => $row[4],
    //         "city"          => $row[5],
    //         "country"       => $row[6],
    //         "phone_1"       => $row[7],
    //         "phone_2"       => $row[8],
    //         "email"         => $row[9],
    //         "subscription_date" => $row[10],
    //         "website"           => $row[11]
    //     ];
    // };

    // foreach( ArrayHelpers::chunkFile($csvPath, $generateRow, $chunkSize = 1000) as $chunk) {
    //     Customer::Insert($chunk);
    // }

    // fclose($file);
    
    $escapedPath = DB::getPdo()->quote($csvPath);

    DB::statement("
        LOAD DATA LOCAL INFILE {$escapedPath}
        INTO TABLE customers
        FIELDS TERMINATED BY ','
        LINES TERMINATED BY '\\n'
        (customer_id, first_name, last_name, company, city, country, phone_1, phone_2, email, subscription_date, website)
    ");

    return "import success";
});
