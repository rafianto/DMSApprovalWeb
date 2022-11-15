<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'dev'),
        'host'           => env('DB_HOST', '172.16.200.52'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', 'MBS'),
        'username'       => env('DB_USERNAME', 'mbs'),
        'password'       => env('DB_PASSWORD', 'mbs123'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
