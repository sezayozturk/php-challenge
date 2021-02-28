<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Mobile Application Subscription Managment API
	|--------------------------------------------------------------------------
	*/

	'allowLanguages'       => ['tr','en'],
	'allowOperationSystem' => ['ios','android'],

	'purchase_verification_ios_url'     => env('PURCHASE_VERIFICATION_IOS_URL','/api/purchase/verification/ios'),
	'purchase_verification_android_url' => env('PURCHASE_VERIFICATION_ANDROID_URL','/api/purchase/verification/android'),

];
