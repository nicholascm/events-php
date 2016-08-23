<?php


Route::get('/', function () {
    return view('welcome');
});

//search for event where event exists for today AND result from YELP api.

Route::get('/api/events/search/{user_id}', 'EventController@index');

//create new Event

Route::post('/api/events', 'EventController@create');

Route::get('/events', function() { return view('layouts.app');  });

Route::get('/api/yelp/search', 'YelpController@search');

//protected route
Route::get('/api/authenticate', 'AuthenticateController@index');
//authentication with JWT
Route::post('/api/authenticate', 'AuthenticateController@authenticate');
Route::post('/api/signup', 'AuthenticateController@signup');
