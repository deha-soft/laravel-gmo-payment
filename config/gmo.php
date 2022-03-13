<?php

return [
    'host' => env('GMO_HOST', ''),
    'site_id' => env('GMO_SITE_ID', ''),
    'site_pass' => env('GMO_SITE_PASS', ''),
    'shop_id' => env('GMO_SHOP_ID', ''),
    'shop_pass' => env('GMO_SHOP_PASS', ''),

    'member_model' => App\Models\User::class,

    'log' => [
        'name' => 'gmo',
        'path' => 'logs/gmo/'
    ],

    'seq_mode' => 1,
];