<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function() {
    Route::resource('Airline', 'AirlinesController');
    Route::resource('Airplane', 'AirplanesController');
    Route::resource('Airport', 'AirportsController');
    Route::resource('BankAccount', 'BankAccountsController');
    Route::resource('Bank', 'BankController');
    Route::resource('BookedFlight', 'BookedFlightsController');
    Route::resource('CanceledFlight', 'CanceledFlightsController');
    Route::resource('City', 'CitiesController');
    Route::resource('Country', 'CountriesController');
    Route::resource('FlightOffer', 'FlightOffersController');
    Route::resource('Flight', 'FlightsController');
    Route::resource('FlightType', 'FlightTypesController');
    Route::resource('Hotel', 'HotelsController');
    Route::resource('Offer', 'OffersController');
    Route::resource('UserProfile', 'UserProfileController');
    Route::resource('User', 'UsersController');
});
