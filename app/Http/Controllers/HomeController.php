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
        // $loginId = Date('ymdHms');
        // Login::create(['login_id' => $loginId]);
        
        DB::transaction(function () {
            // Lock the table or a specific row to ensure uniqueness
            DB::table('logins')->lockForUpdate()->get();
        
            // Generate the login_id
            $loginId = date('ymdHms');
        
            // Check if the login_id already exists
            while (DB::table('logins')->where('login_id', $loginId)->exists()) {
                // If it exists, wait for 1 second and regenerate
                sleep(1);
                $loginId = date('ymdHms');
            }
        
            // Create the new login record
            Login::create(['login_id' => $loginId]);
        });
        

        return "success";
    }
}
