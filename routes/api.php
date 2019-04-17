<?php

use Illuminate\Http\Request;

Route::get('info', 'CanarieController@info');
Route::get('stats', 'CanarieController@stats');
Route::get('{page}', 'CanarieController@page');
