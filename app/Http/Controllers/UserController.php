<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
       
            if (!$user || !Hash::check($request->password, $user->password, [])) {

                return response()->json(
                [
                    'status_code' => 401,
                    'message' => "Login fails"
                ], 401);
            }
	
            $accessToken = $user->createToken('user')->plainTextToken;
            $data = [
                'access_token' => $accessToken,
          	    'token_type' => 'Bearer'
        	];

            return response()->json([
                'status_code' => 200,
                'message' => "Login succuss",
                'data' => $data
            ], 200);

        } catch (\Exception $error) {
            throw $error;
        }

    }

    public function logout()
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->success('Logout success','',200);
    }
}
