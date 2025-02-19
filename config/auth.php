<?php

return [

    'defaults' => [
        'guard' => 'admin', // ✅ Ensure 'admin' is set
        'passwords' => 'admins',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins', // ✅ Ensure this matches the provider
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminLogin::class, // ✅ Ensure this exists in Models
        ],
    ],

];
