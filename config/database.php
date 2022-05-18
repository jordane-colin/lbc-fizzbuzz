<?php

return [
    'default' => 'mongodb',
    'connections' => [
        'mongodb' => array(
            'driver'   => env('DB_CONNECTION', 'mongodb'),
            'host'     => env('DB_HOST', 'fizzbuzz-mongodb'),
            'port'     => env('DB_PORT', 27017),
            'username' => env('DB_USERNAME', 'fizzbuzz'),
            'password' => env('DB_PASSWORD', 'secret'),
            'database' => env('DB_DATABASE', 'fizzbuzz')
        ),

    ],
    'migrations' => 'migrations',
];
