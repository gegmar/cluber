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

Route::get('/', 'StartController@index')->name('start');

/**
 * Public ticket shop routes
 */
Route::namespace('TicketShop')->prefix('ts')->name('ts.')->group(function () {
    Route::get('/seatmap/{event}', 'SeatMapController@selectSeats')->name('seatmap');
});

Route::prefix('/layout')->group(function () {
    Route::get('/', function () {
        return view('layouts.start');
    });

    Route::get('/login', function () {
        return view('layouts.login');
    });

    Route::get('/register', function () {
        return view('layouts.register');
    });
});