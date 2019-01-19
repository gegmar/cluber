<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'TicketShop\EventsController@index')->name('start');

/**
 * Footer-Routes
 */
Route::get('/privacy', 'PublicPagesController@privacyStatement')->name('privacy');
Route::get('/terms', 'PublicPagesController@termsAndConditions')->name('terms');
Route::get('/impress', 'PublicPagesController@impress')->name('impress');

/**
 * Public ticket shop routes
 */
Route::namespace('TicketShop')->prefix('ts')->name('ts.')->group(function () {

    Route::get('/', 'EventsController@index')->name('events');

    Route::get('/{event}/seatmap', 'SeatMapController@getSeats')->name('seatmap');
    Route::post('/{event}/seatmap', 'SeatMapController@setSeats')->name('setSeatMap');

    Route::get('/my-data', 'CustomerDataController@getData')->name('customerData');
    Route::post('/my-data', 'CustomerDataController@setData')->name('setCustomerData');

    Route::get('/overview', 'CheckoutController@getOverview')->name('overview');
    Route::post('/pay', 'CheckoutController@startPayment')->name('pay');

    // PaymentProvider URLs
    Route::prefix('payment')->group(function () {
        Route::get('{purchase}/successful', 'CheckoutController@paymentSuccessful')->name('payment-successful');
        Route::get('{purchase}/aborted', 'CheckoutController@paymentAborted')->name('payment-aborted');
        Route::get('{purchase}/timedout', 'CheckoutController@paymentTimedOut')->name('payment-timedout');
    });

});