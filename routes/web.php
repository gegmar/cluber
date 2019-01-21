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
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('{purchase}/successful/{secret}', 'CheckoutController@paymentSuccessful')->name('successful');
        Route::get('{purchase}/aborted', 'CheckoutController@paymentAborted')->name('aborted');
        Route::get('{purchase}/timedout', 'CheckoutController@paymentTimedOut')->name('timedout');

        Route::name('notify.')->group(function () {
            Route::get('{purchase}/{secret}/loss', 'CheckoutController@notifyLoss')->name('loss');
            Route::get('{purchase}/{secret}/pending', 'CheckoutController@notifyPending')->name('pending');
            Route::get('{purchase}/{secret}/received', 'CheckoutController@notifyReceived')->name('received');
            Route::get('{purchase}/{secret}/refunded', 'CheckoutController@notifyRefunded')->name('refunded');
        });

        // PaymentProvider-specific URLs
        Route::get('{purchase}/{secret}/paypal/executepayment', 'PaymentProviderController@payPalExecutePayment')->name('payPalExec');

    });

});

// All routes regarding fetching tickets for purchases
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('{purchase}/all', 'TicketController@showPurchase')->name('purchase');
    Route::get('{purchase}/download', 'TicketController@download')->name('download');
});