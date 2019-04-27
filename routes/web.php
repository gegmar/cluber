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

Route::get('/', 'StartController@index')->name('start');

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

    Route::get('/overview', 'CheckOutController@getOverview')->name('overview');
    Route::post('/pay', 'CheckOutController@startPayment')->name('pay');

    // PaymentProvider URLs
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('{purchase}/successful/{secret}', 'CheckOutController@paymentSuccessful')->name('successful');
        Route::get('{purchase}/aborted', 'CheckOutController@paymentAborted')->name('aborted');
        Route::get('{purchase}/timedout', 'CheckOutController@paymentTimedOut')->name('timedout');

        Route::name('notify.')->group(function () {
            Route::get('{purchase}/{secret}/loss', 'CheckOutController@notifyLoss')->name('loss');
            Route::get('{purchase}/{secret}/pending', 'CheckOutController@notifyPending')->name('pending');
            Route::get('{purchase}/{secret}/received', 'CheckOutController@notifyReceived')->name('received');
            Route::get('{purchase}/{secret}/refunded', 'CheckOutController@notifyRefunded')->name('refunded');
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
            Route::post('/setpaid/{purchase}', 'SoldTicketsController@setToPaid')->name('paid');
            Route::delete('/delete/{purchase}', 'SoldTicketsController@deletePurchase')->name('delete');
        });
    });

    // Events routes
    Route::middleware(['perm:SELL_TICKETS'])->namespace('Events')->prefix('events')->name('events.')->group(function () {

        Route::get('/', 'StatisticsController@dashboard')->name('dashboard');
        Route::get('/{event}/pdf-overview.pdf', 'StatisticsController@downloadOverview')->name('download-overview');
    });

    // Supervisor routes
    Route::middleware(['perm:SUPERVISE'])->namespace('Supervision')->prefix('supervision')->name('supervision.')->group(function () {

        Route::get('/', 'AnalyticController@dashboard')->name('dashboard');
        Route::get('/{project}/export.csv', 'AnalyticController@downloadCSV')->name('export-csv');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () { });
});
