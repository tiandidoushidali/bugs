<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', 'TestController@test');
Route::get('/aaaa', function () {
    return view('welcome');
});
Route::get('/mail', 'TestController@mailTest');

Route::get('/test/job', 'TestController@jobTest');


Route::get('/test/statictestset', 'TestController@staticTest');


Route::get('/test/statictestget', 'TestController@staticTest1');

Route::get('/test/test', 'TestController@test');
Route::get('/test/sign', 'TestController@testSign');

Route::get('/test/redis', 'TestController@redisSentinelsTest');

Route::group(['middleware'=>'api'], function(){
    Route::get('/test/test', 'TestController@test');
    Route::get('/test/test1', 'TestController@test1');
});
    