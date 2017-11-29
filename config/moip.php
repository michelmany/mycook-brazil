<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Defining application environment
    |--------------------------------------------------------------------------
    |
    | Define the key and the token has been approved by MoIP
    | If true, it will use the production environment
    | If false, it will use the development environment (sandbox)
    |
    */

    'homologated' => env('MOIP_HOMOLOGATED', false),

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | Any request to the API must be passed two keys
    | key and token the environment configured in "homologated"
    |
    */
    'credentials' => [
        'key' => env('MOIP_KEY', 'AKBBQINYBUVVPCIN143LOZM35ZFBAPGMH5JA9VDD'),
        'token' => env('MOIP_TOKEN', 'WKK0KABHCSKKLBF0HSPRGV7Z80Y32C6O'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketplace
    |--------------------------------------------------------------------------
    |
    | Configurações do aplicativo que o "moip marketplace" disponibiliza
    |
    */
    'marketplace' => [
        'endpoint' => env('MARKETPLACE_ENDPOINT', \Moip\Auth\Connect::ENDPOINT_PRODUCTION),
        'id'  => getenv('MARKETPLACE_ID'),
        'name' => 'MyCook',
        'description' => 'Delivery de comida caseira online',
        'token' => getenv('MARKETPLACE_TOKEN'),
        'secret'   => getenv('MARKETPLACE_SECRET'),
        'redirect' => getenv('APP_URL' ) . '/moip/marketplace/callback'
    ],

    'settings' => [
        'percentage_rate' => 5.49, // porcentagem
        'additional_rate' => 0.69 // valor
    ]
];
