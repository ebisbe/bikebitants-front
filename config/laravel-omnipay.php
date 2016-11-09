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
				'username' => env('PAYPAL_USERNAME'),
				'password' => env('PAYPAL_PASSWORD'),
				'signature' => env('PAYPAL_SIGNATURE'),
				"testMode" => env('PAYPAL_TESTMODE'),
				"brandName" => "Bikebitants",
				'headerImageUrl' => '',
				"logoImageUrl" => "",
				"borderColor" => "",
				'currency' => 'EUR',
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
		]
	]

];