<?php

return [
    'default' => env('CACHE_STORE', 'database'),
    'stores' => [
        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION'),
            'table' => env('CACHE_TABLE', 'cache'),
            'lock_connection' => env('CACHE_LOCK_CONNECTION'),
            'lock_table' => env('CACHE_LOCK_TABLE'),
        ],
    ],
    'prefix' => env('CACHE_PREFIX', 'agrowaste_cache'),
];
