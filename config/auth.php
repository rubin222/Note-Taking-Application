<?php

return [
    //sets default guard and default password broker.
    //uses session based authentication by default for web requests
    //uses users password broker for resets
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


//defines web guard, session/cookie based login, uses the users providers
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
//defines API guard, uses JWT tokens instead of session for API requests
//uses same users providers
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    //define user provider
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
//for password resets, uses the user provider
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',       //table where tokens are stored
            'expire' => 60,                           //tokens expire in 60 min
            'throttle' => 60,                           //limites requests to 1 per 60 sec 
        ],
    ],

    'password_timeout' => 10800,
];