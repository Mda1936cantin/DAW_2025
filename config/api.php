<?php

return [
    'ventas' => [
        'base_url' => env('VENTAS_API_URL', 'http://host.docker.internal:8000'),
        'endpoints' => [
            'login' => '/login',
            'ventas' => '/ventas',
        ],
        'credentials' => [
            'email' => env('VENTAS_API_EMAIL', 'dawpt2@utn.edu'),
            'password' => env('VENTAS_API_PASSWORD', 'badpassword1234'),
        ],
    ],
];
