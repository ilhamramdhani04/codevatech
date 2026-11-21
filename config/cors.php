<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi CORS eksplisit untuk DiagnoLap.
    | Karena ini aplikasi web server-rendered (bukan SPA + API terpisah),
    | CORS dibuat restrictive by default.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],

    'allowed_origins' => [
        env('APP_URL', 'http://localhost'),
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 86400, // 24 jam

    'supports_credentials' => true,

];
