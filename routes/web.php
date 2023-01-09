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
        Route::get('dashboard', 'HomeController@adminView')->name('dashboard');
        Route::get('schools/create', 'SchoolsController@create')->name('schools_create');
        Route::post('schools/store', 'SchoolsController@store')->name('schools_store');
        Route::post('schools/destroy', 'SchoolsController@destroy')->name('schools_destroy');
        Route::get('schools/edit/{id}', 'SchoolsController@edit')->name('schools_edit');
        Route::post('schools/update', 'SchoolsController@update')->name('schools_update');
    });

    Route::group(['namespace' => 'Schools', 'prefix' => 'school', 'as' => 'school.'], function () {

        Route::get('dashboard', 'HomeController@index')->name('dashboard');

        // * Eventos
        Route::group(['prefix' => 'eventos', 'as' => 'events.'], function () {
            Route::get('create', 'EventsController@create')->name('create');
            Route::post('store', 'EventsController@store')->name('store');
            Route::get('edit/{event_id}', 'EventsController@edit')->name('edit');
            Route::post('update', 'EventsController@update')->name('update');

            Route::get('list', 'EventsController@viewAll')->name('view');
        });
    });
});
