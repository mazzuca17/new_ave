<?php

use App\Http\Controllers\Schools\CoursesController;
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
        Route::group(['prefix' => 'schools', 'as' => 'schools.'], function () {
            Route::get('create', 'SchoolsController@create')->name('create');
            Route::post('store', 'SchoolsController@store')->name('store');
            Route::post('destroy', 'SchoolsController@destroy')->name('destroy');
            Route::get('edit/{id}', 'SchoolsController@edit')->name('edit');
            Route::post('update', 'SchoolsController@update')->name('update');
        });
        Route::get('dashboard', 'HomeController@adminView')->name('dashboard');
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

        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
            Route::get('', [CoursesController::class, 'index'])->name('index');
            Route::get('new', [CoursesController::class, 'showFormNew'])->name('new');
            Route::post('create', [CoursesController::class, 'saveNewCourse'])->name('create');
        });
    });
});
