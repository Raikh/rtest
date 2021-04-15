<?php

return [
    'admin' => [
        'prefix' => env('ADMIN_PREFIX', 'admin'),
    ],
    'transactions' => [
        'wallet' => [
            'lock_ttl' => env('WALLET_LOCK_TTL', 1*60) // 1 minute
        ]
    ]
];
