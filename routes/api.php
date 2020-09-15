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
    Route::get('UserInfo', 'GuestController@UserInfo');
    Route::get('BookFlight/{FlightID}/{UserAccountID}', 'GuestController@BookFlight');
    Route::get('UserBookFlight', 'GuestController@UserBookFlight');
    Route::get('BookedFlightsIndex', 'CustomersController@BookedFlightsIndex');
    Route::get('CanceledFlightsIndex', 'CustomersController@CanceledFlightsIndex');
});

Route::post('FileDownload', 'FilesController@FileDownload');

Route::resource('Airline', 'AirlinesController');
Route::post('Airline/{id}', 'AirlinesController@update');
Route::resource('Airplane', 'AirplanesController');
Route::post('Airplane/{id}', 'AirplanesController@update');
Route::resource('Airport', 'AirportsController');
Route::post('Airport/{id}', 'AirportsController@update');
Route::resource('BankAccount', 'BankAccountsController');
Route::post('BankAccount/{id}', 'BankAccountsController@update');
Route::resource('Bank', 'BankController');
Route::post('Bank/{id}', 'BankController@update');
Route::resource('BookedFlight', 'BookedFlightsController');
Route::post('BookedFlight/{id}', 'BookedFlightsController@update');
Route::resource('CanceledFlight', 'CanceledFlightsController');
Route::post('CanceledFlight/{id}', 'CanceledFlightsController@update');
Route::resource('City', 'CitiesController');
Route::post('City/{id}', 'CitiesController@update');
Route::resource('Country', 'CountriesController');
Route::post('Country/{id}', 'CountriesController@update');
Route::resource('FlightOffer', 'FlightOffersController');
Route::post('FlightOffer/{id}', 'FlightOffersController@update');
Route::resource('Flight', 'FlightsController');
Route::post('Flight/{id}', 'FlightsController@update');
Route::resource('FlightType', 'FlightTypesController');
Route::post('FlightType/{id}', 'FlightTypesController@update');
Route::resource('Hotel', 'HotelsController');
Route::post('Hotel/{id}', 'HotelsController@update');
Route::resource('Offer', 'OffersController');
Route::post('Offer/{id}', 'OffersController@update');
Route::resource('UserProfile', 'UserProfileController');
Route::post('UserProfile/{id}', 'UserProfileController@update');
Route::resource('User', 'UsersController');
Route::post('User/{id}', 'UsersController@update');


Route::post('Search', 'GuestController@Search');

