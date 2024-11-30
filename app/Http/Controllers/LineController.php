<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LineService;
use Illuminate\View\View;

class LineController extends Controller
{   
    protected $lineService;

    public function __construct(LineService $lineService)
    {
        $this->lineService = $lineService;
    }

    public function login(Request $request) {
        $authUrl = $this->lineService->getLoginBaseUrl();

        return view('line.login', compact('authUrl'));
    }

    public function callback(Request $request)
    {
        $code = $request->input('code', '');
        $response = $this->lineService->getLineToken($code);

        dd($response);
        // Get profile from access token.
        // $profile = $this->lineService->getLineToken($code);
        // Get profile from ID token
        $profile = $this->lineService->verifyIDToken($response['id_token']);

        dd($profile);
    }
}
