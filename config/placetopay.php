<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base url placetopay
    |--------------------------------------------------------------------------
    |
    | This value is the url of placetopay redirection api
    |
    */
    'baseUrl' => env('P2P_BASE_URL', 'https://test.placetopay.com/redirection/'),

    /*
    |--------------------------------------------------------------------------
    | ID
    |--------------------------------------------------------------------------
    |
    | This value is the identification received from placetopay
    |
    */
    'authId' => env('P2P_AUTH', '6dd490faf9cb87a9862245da41170ff2'),

    /*
    |--------------------------------------------------------------------------
    | SecretKey
    |--------------------------------------------------------------------------
    |
    | This value is the time to wait for response
    |
    */
    'timeout' => env('P2P_TIMEOUT', 3.0),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | This value is the secret key received from placetopay
    |
    */
    'secretKey' => env('P2P_SECRET_KEY', '024h1IlD'),
];
