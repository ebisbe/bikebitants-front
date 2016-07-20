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
			]
		],
		'redsys' => [
			'driver' => 'Sermepa',
			'options' => [
				'titular' => '336022801',
				'consumerLanguage' => '001',
				'currency' => '978',
				'terminal' => '001',
				'merchantURL' => 'https://sis.redsys.es/sis/realizarPago',
				'merchantName' => '336022801',
				'merchantKey' => 'qwertyasdf0123456789',//'Hz08jlJIWV5+36GUXRjgMZcCWIgM/GqW',
				'transactionType' => '0',
				'signatureMode' => 'simple',
				'testMode' => true
			]
		]
	]

];