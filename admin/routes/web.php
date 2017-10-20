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

// frontend
Route::any('/', function () {
    return redirect('/home');
});

// auth系统
Auth::routes();

// home
include __DIR__ . '/home/home.php';
