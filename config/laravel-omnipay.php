<?php

return [

    // The default gateway to use
    'default' => 'paypal',

    // Add in each gateway here
    'gateways' => [
        'paypal' => [
            'driver'  => 'PayPal_Express',
            'options' => [
                'solutionType'   => '',
                'landingPage'    => '',
                'username' => env('OMNIPAY_PAYPAL_USERNAME'),
                'password' => env('OMNIPAY_PAYPAL_PASSWORD'),
                'signature' => env('OMNIPAY_PAYPAL_SIGNATURE'),
                "testMode" => env('OMNIPAY_PAYPAL_TESTMODE'),
                "brandName" => "Bikebitants",
                'headerImageUrl' => '',
                "logoImageUrl" => "",
                "borderColor" => "",
                "currency" => "EUR",
            ]
        ],
        'redsys' => [
            'driver' => 'Sermepa',
            'options' => [
                'currency' => '978',
                'terminal' => '001',
                'merchantKey' => env('OMNIPAY_REDSYS_MERCHANT_KEY'),
                'transactionType' => '0',
                'signatureMode' => 'simple',
                'consumerLanguage' => '001',
                'merchantName' => 'Bikebitants. Tu bici, tu ciudad.',
                'merchantCode' => '336022801',
                'merchantURL' => env('OMNIPAY_REDSYS_MERCHANT_URL'),
                'testMode' => env('OMNIPAY_REDSYS_TESTMODE'),
            ]
        ],
        'Fake' => [
            'driver' => 'Fake',
            'options' => []
        ]
    ]

];
