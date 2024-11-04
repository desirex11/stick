<?php

return [

    'default' => env('BROADCAST_DRIVER', 'null'),

    'connections' => [

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'reverb' => [
        'driver' => 'reverb',
        'host' => env('REVERB_HOST', 'localhost'),
        'key' => env('REVERB_KEY'),
        'secret' => env('REVERB_SECRET'),
        // Add other Reverb-specific configuration as needed
    ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
