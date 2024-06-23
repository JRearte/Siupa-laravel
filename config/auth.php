<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuario',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuario', // Cambiado a singular
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'usuario', // Cambiado a singular
            'hash' => false,
        ],
    ],

    'providers' => [
        'usuario' => [ // Cambiado a singular
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],
    ],

    'passwords' => [
        'usuario' => [ // Cambiado a singular
            'provider' => 'usuario', // Cambiado a singular
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
