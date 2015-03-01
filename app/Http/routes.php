<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('amcharts/{searchId?}', ['as' => 'amcharts', 'uses' => 'HomeController@amcharts']);
Route::get('google-charts/{searchId?}', ['as' => 'google_charts', 'uses' => 'HomeController@google_charts']);
