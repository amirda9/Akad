<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('Api')->group(function () {

    // web apis
    Route::get('/provinces', 'PublicController@provinces');
    Route::get('/cities', 'PublicController@cities');
    Route::get('/shippings', 'PublicController@shippings');

});
