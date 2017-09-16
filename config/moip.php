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
        'endpoint' => \Moip\Auth\Connect::ENDPOINT_SANDBOX,
        'id'  => 'APP-EURUAE9P0BCA',
        'name' => 'MyCook',
        'description' => 'Plataforma Marketplace Delivery',
        'token' => '60272841f9d7473a9530d11503e6c2a2_v2',
        'secret'   => '83c763f18c014335bab599d94bc6b436',
        'redirect' => getenv('APP_URL' ) . '/moip/marketplace/callback'
    ]
];
