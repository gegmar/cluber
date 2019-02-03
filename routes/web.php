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
Auth::routes(['verify' => true]);

Route::get('setlang/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
})->name('set-locale');

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
    Route::get('{ticket}', 'TicketsController@showTicket')->name('show');
    Route::get('{purchase}/all', 'TicketsController@showPurchase')->name('purchase');
    Route::get('{purchase}/download', 'TicketsController@download')->name('download');
});

// The following routes are only accessible for verified and authenticated users
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'ProfileController@get')->name('show');
        Route::post('update', 'ProfileController@update')->name('update');
    });

    // Retail routes
    Route::middleware(['perm:SELL_TICKETS'])->namespace('Retail')->prefix('retail')->name('retail.')->group(function () {
        // Handle selling tickets
        Route::prefix('sell')->name('sell.')->group(function () {
            Route::get('/', 'SellTicketsController@events')->name('events');
            Route::get('/{event}/seats', 'SellTicketsController@seats')->name('seats');
            Route::post('/{event}/sell', 'SellTicketsController@sellTickets')->name('sell');
        });

        // Handle already sold tickets
        Route::prefix('sold')->name('sold.')->group(function () {
            Route::get('/', 'SoldTicketsController@getPurchases')->name('tickets');
            Route::delete('/delete/{purchase}', 'SoldTicketsController@deletePurchase')->name('delete');
        });
    });

    // Events routes
    Route::middleware(['perm:SELL_TICKETS'])->namespace('Events')->prefix('events')->name('events.')->group(function () {

        Route::get('/', 'StatisticsController@dashboard')->name('dashboard');
        Route::get('/{event}/pdf-overview.pdf', 'StatisticsController@downloadOverview')->name('download-overview');

    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {

    });
});