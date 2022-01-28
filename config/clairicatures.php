<?php

return [
    'contract_address' => env('CONTRACT_ADDRESS'),
    'front_end_url' => env('FRONT_END_URL'),
    'json_rpc' => [
        'url' => env('JSON_RPC_URL'),
    ],
    'chain' => env('CHAIN', 'matic'),
    'open_sea_base_url' => env('OPEN_SEA_BASE_URL', 'https://opensea.io/assets/'),
    'wallet' => [
        'encrypted_json' => file_exists(__DIR__.'/../blockchain/wallet.json') ?
            file_get_contents(__DIR__.'/../blockchain/wallet.json') : null,
        'password' => env('WALLET_PASSWORD'),
    ],
    'gas_price' => env('GAS_PRICE', 200000000000),
];
