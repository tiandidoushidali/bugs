<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/aaaa', function (Request $request) {
    return $request->user();
});
Route::get('/bbb', function () {
    echo 'bbbbb';exit;
    return view('welcome');
});