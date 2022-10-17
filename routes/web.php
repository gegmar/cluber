<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/setlang/{locale}', 'StartController@changeLocale')->name('set-locale');
Route::get('/logo', 'StartController@getLogo')->name('logo');

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
        Route::get('{purchase}/successful/{secret}', 'PaymentProviderController@paymentSuccessful')->name('successful');
        Route::get('{purchase}/aborted', 'PaymentProviderController@paymentAborted')->name('aborted');
        Route::get('{purchase}/timedout', 'PaymentProviderController@paymentTimedOut')->name('timedout');

        // PaymentProvider-specific URLs
        // PayPal
        Route::get('{purchase}/{secret}/paypal/executepayment', 'PaymentProviderController@payPalExecutePayment')->name('payPalExec');

        // Mollie
        Route::prefix('mollie')->name('mollie.')->group(function () {
            Route::post('/webhook', 'MollieController@processWebhook')->name('webhook');
            Route::get('/{purchase}/update', 'MollieController@getPaymentUpdate')->name('purchase-update');
        });
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

    // Box Office routes
    Route::middleware(['perm:SELL_TICKETS'])->namespace('BoxOffice')->prefix('boxoffice')->name('boxoffice.')->group(function () {

        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
        Route::get('/{event}/download.pdf', 'DashboardController@downloadOverview')->name('download-overview');
        Route::get('/{event}/download-id.pdf', 'DashboardController@downloadOverviewById')->name('download-overview-id');

        Route::get('/{event}/online', 'OnlineController@index')->name('online');
        Route::post('/{ticket}/change-state', 'OnlineController@switchTicketState')->name('switch-ticket-state');
        Route::post('/{event}/setBoxOfficeSales', 'OnlineController@setBoxOfficeSales')->name('set-sales');
    });

    // Supervisor routes
    Route::middleware(['perm:SUPERVISE'])->namespace('Supervision')->prefix('supervision')->name('supervision.')->group(function () {

        Route::get('/', 'AnalyticController@dashboard')->name('dashboard');
        Route::get('/{project}/export.csv', 'AnalyticController@downloadCSV')->name('export-csv');
        Route::get('/{project}/helgametrics.csv', 'AnalyticController@downloadHelgaMetrics')->name('export-helga-metrics');
    });

    // Admin routes
    Route::middleware(['perm:ADMINISTRATE'])->namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

        // Manage projects and events
        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', 'EventController@index')->name('dashboard');

            Route::get('/create', 'EventController@showCreate')->name('show-create');
            Route::post('/create', 'EventController@create')->name('create');
            Route::get('/{event}', 'EventController@get')->name('get');
            Route::post('/{event}/update', 'EventController@update')->name('update');
            Route::post('/{event}/delete', 'EventController@delete')->name('delete');
            Route::get('/{event}/test-ticket', 'EventController@testTicket')->name('test-ticket');

            Route::prefix('project')->name('project.')->group(function () {
                Route::post('/create', 'ProjectController@create')->name('create');
                Route::get('/{project}', 'ProjectController@get')->name('get');
                Route::post('/{project}/update', 'ProjectController@update')->name('update');
                Route::post('/{project}/delete', 'ProjectController@delete')->name('delete');
                Route::post('/{project}/archive', 'ProjectController@archive')->name('archive');
                Route::post('/{project}/restore', 'ProjectController@restore')->name('restore');
            });
        });

        // Manage seatmaps, pricelists and locations
        Route::prefix('dependencies')->name('dependencies.')->group(function () {
            Route::get('/', 'SeatMapController@index')->name('dashboard');

            Route::prefix('seatmap')->name('seatmap.')->group(function () {
                Route::post('/create', 'SeatMapController@create')->name('create');
                Route::get('/{seatMap}', 'SeatMapController@get')->name('get');
                Route::post('/{seatMap}/update', 'SeatMapController@update')->name('update');
                Route::delete('/{seatMap}/delete', 'SeatMapController@delete')->name('delete');
            });

            Route::prefix('location')->name('location.')->group(function () {
                Route::post('/create', 'LocationController@create')->name('create');
                Route::get('/{location}', 'LocationController@get')->name('get');
                Route::post('/{location}/update', 'LocationController@update')->name('update');
                Route::delete('/{location}/delete', 'LocationController@delete')->name('delete');
            });

            Route::prefix('prices')->name('prices.')->group(function () {
                Route::prefix('category')->name('category.')->group(function () {
                    Route::post('/create', 'PriceCategoryController@create')->name('create');
                    Route::get('/{category}', 'PriceCategoryController@get')->name('get');
                    Route::post('/{category}/update', 'PriceCategoryController@update')->name('update');
                    Route::delete('/{category}/delete', 'PriceCategoryController@delete')->name('delete');
                });

                Route::prefix('list')->name('list.')->group(function () {
                    Route::post('/create', 'PriceListController@create')->name('create');
                    Route::get('/{list}', 'PriceListController@get')->name('get');
                    Route::post('/{list}/update', 'PriceListController@update')->name('update');
                    Route::delete('/{list}/delete', 'PriceListController@delete')->name('delete');
                });
            });
        });

        // User and Role Management (=Identity and Access Management [IAM])
        Route::prefix('iam')->name('iam.')->group(function () {
            Route::get('/', 'UserController@index')->name('dashboard');

            Route::prefix('user')->name('user.')->group(function () {
                Route::get('/{user}', 'UserController@displayUser')->name('manage');
                Route::post('/{user}/update', 'UserController@updateUser')->name('update');
            });

            Route::prefix('role')->name('role.')->group(function () {
                Route::get('/{role}', 'RoleController@displayRole')->name('manage');
                Route::post('/add', 'RoleController@createRole')->name('create');
                Route::post('/{role}/update', 'RoleController@updateRole')->name('update');
                Route::delete('/{role}/delete', 'RoleController@deleteRole')->name('delete');

                Route::post('/{role}/attach-users', 'RoleController@attachUsers')->name('attach-users');
                Route::delete('/{role}/detach-user/{user}', 'RoleController@detachUser')->name('detach-user');
            });
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'SettingsController@index')->name('dashboard');
            Route::post('/terms-and-conditions/update', 'SettingsController@updateTerms')->name('update-terms');
            Route::post('/privacy-statement/update', 'SettingsController@updatePrivacy')->name('update-privacy');
            Route::post('/logo/update', 'SettingsController@updateLogo')->name('update-logo');
            Route::delete('/logo/delete', 'SettingsController@deleteLogo')->name('delete-logo');
            Route::get('/logo/test-ticket', 'SettingsController@testTicket')->name('test-ticket');
        });
    });
});
