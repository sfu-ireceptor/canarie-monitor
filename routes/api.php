<?php

use Illuminate\Http\Request;

Route::get('stats', 'CanarieController@stats');
Route::get('{page}', 'CanarieController@page');
