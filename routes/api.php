<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

//salami IPN
Route::any('/salami/callback', 'SalamiController@salamiCallback');