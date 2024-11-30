<?php

return [

    'line_profile_uri' => 'https://api.line.me/v2/profile',

    'line_token_uri' => 'https://api.line.me/oauth2/v2.1/token',

    'line_authorize_uri' => 'https://access.line.me/oauth2/v2.1/authorize',

    'line_verify_uri' => 'https://api.line.me/oauth2/v2.1/verify',
    
    'line_client_id' => env('LINE_LOGIN_CHANNEL_ID'),

    'line_client_secret' => env('LINE_LOGIN_CHANNEL_SECRET')
];