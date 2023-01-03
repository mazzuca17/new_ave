<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Rutas con autenticación
Route::group(['middleware' => ['auth']], function () {

    // School or Admin
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('admin-view', 'HomeController@adminView')->name('admin.view');
    });
});
