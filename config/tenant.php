<?php
return [

    'database'   => [
        'username'   => env('ROOT_USER', ''),
        'password'   => env('ROOT_PASSWORD', ''),
        'db_prefix'  => env('ROOT_DB_PREFIX', ''),
        'tbl_prefix' => env('ROOT_TABLE_PREFIX', '')

    ],



    'currencies' => [
        'NOK' => 'NOK',
        'GBP' => 'GBP',
        'EUR' => 'EUR',
        'USD' => 'USD',
        'AUD' => 'AUD',
        'NZD' => 'NZD',
        'CHF' => 'CHF',
        'PLN' => 'PLN',
        'DKK' => 'DKK',
        'SEK' => 'SEK',
        'CNY' => 'CNY'
    ],
    'vat'        => [
        8  => '8%',
        15 => '15%',
        25 => '25%',
        0  => 'Foreign/Domestic Exempt'
    ],
];
