<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//search for event where event exists for today AND result from YELP api.

Route::get('/api/events/{user_id}', 'EventController@index');

//create new Event

Route::post('/api/events', 'EventController@create');

Route::get('/events', function() { return view('layouts.app');  });

Route::get('/api/yelp/search', 'YelpController@search');

//protected route
Route::get('/api/authenticate', 'AuthenticateController@index');
//authentication with JWT
Route::post('/api/authenticate', 'AuthenticateController@authenticate');
Route::post('/api/signup', 'AuthenticateController@signup');
