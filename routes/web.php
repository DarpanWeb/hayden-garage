<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
})->name('application');

Route::get('/book-slots', function () {
    return view('bookingForm');
});

Route::get('/admin', function () {
    return view('adminPanel');
});

Route::get('/admin/{any}', function () {
    return view('adminPanel');
})->where('any', '.*');


$router->post('/save-booking', ['uses' => 'BookingController@bookSlots']);
$router->get('/get-bookings', ['uses' => 'BookingController@getBookings']);
$router->get('/get-available-slots', ['uses' => 'slotMasterController@getAvailableSlots']);
$router->post('/disable-slots', ['uses' => 'slotMasterController@disableSlots']);
