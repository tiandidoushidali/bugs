<?php
/**
 * Created by PhpStorm.
 * User: yanrong
 * Date: 2017/6/11
 * Time: 下午11:37
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'aaa';
    return 'Hello World';
});


Route::group([], function () {

    Route::any('test/sign', 'TestController@testSign');
});