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
		]
	]

];