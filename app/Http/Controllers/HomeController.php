<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function createUser()
    {
        $max = Login::max('login_id');

        Login::create([
            'login_id' => (int) $max + 1
        ]);

        // DB::statement('
        //     INSERT INTO logins (login_id) 
        //     SELECT IFNULL(MAX(login_id), 0) + 1 FROM logins
        // ');

        echo "oke";
    }
}
