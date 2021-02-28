<?php

use Illuminate\Support\Facades\Route;

// Register
Route::post('/register','Api\RegisterController')->name('register');

// Purchase
Route::group(['prefix' => 'purchase','as' => 'purchase.'],function (){
    Route::post('/','Api\PurchaseController')->name('purchase');

    // Verification
    Route::group(['middleware' => 'HttpBasicAuth'],function (){
        Route::post('verification/ios','Api\PurchaseVerificationController@ios')->name('verification.ios');
        Route::post('verification/android','Api\PurchaseVerificationController@android')->name('verification.android');
    });
});

// Check Subscription
Route::post('/subscription','Api\SubscriptionController')->name('subscription');

// Callback - 3rd Party App
Route::post('/3rd-party-app/send','Api\ThirdPartyAppController')->name('thirdPartyApp.send');

// Worker
Route::get('/worker','Api\WorkerController')->name('worker');

// Report
Route::get('/report','Api\ReportController')->name('report');