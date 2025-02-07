<?php

use App\Http\Controllers\Admin\SchoolsController as AdminSchoolsController;
use App\Http\Controllers\Schools\HomeController as SchoolsHomeController;
use App\Http\Controllers\Schools\EventsController;
use App\Http\Controllers\Schools\CoursesController;
use App\Http\Controllers\Schools\ProfesoresController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController as Home;

Route::get('/', [Home::class, 'index'])->name('home');


Auth::routes();



// Rutas con autenticación y roles
Route::middleware(['auth'])->group(function () {

    // Rutas para Superadmin
    Route::middleware('role:Superadmin')->group(function () {
        Route::namespace('Admin')->prefix('admin')->as('admin.')->group(function () {
            Route::prefix('schools')->as('schools.')->group(function () {
                Route::get('create', [AdminSchoolsController::class, 'create'])->name('create');
                Route::post('store', [AdminSchoolsController::class, 'store'])->name('store');
                Route::post('destroy', [AdminSchoolsController::class, 'destroy'])->name('destroy');
                Route::get('edit/{id}', [AdminSchoolsController::class, 'edit'])->name('edit');
                Route::post('update', [AdminSchoolsController::class, 'update'])->name('update');
            });

            Route::get('dashboard', 'HomeController@adminView')->name('dashboard');
        });
    });

    // Rutas para Colegio
    Route::middleware('role:Colegio')->namespace('Schools')->prefix('school')->as('school.')->group(function () {
        Route::get('dashboard', [SchoolsHomeController::class, 'index'])->name('dashboard');

        // Eventos
        Route::prefix('eventos')->as('events.')->group(function () {
            Route::get('create', [EventsController::class, 'create'])->name('create');
            Route::post('store', [EventsController::class, 'store'])->name('store');
            Route::get('edit/{event_id}', [EventsController::class, 'edit'])->name('edit');
            Route::post('update', [EventsController::class, 'update'])->name('update');
            Route::get('list', [EventsController::class, 'viewAll'])->name('view');
        });

        // Cursos
        Route::prefix('courses')->as('courses.')->group(function () {
            Route::get('', [CoursesController::class, 'index'])->name('index');
            Route::get('new', [CoursesController::class, 'showFormNew'])->name('new');
            Route::post('create', [CoursesController::class, 'saveNewCourse'])->name('create');
            Route::get('edit/{id_curso}', [CoursesController::class, 'showFormEdit'])->name('edit');
            Route::post('save_edit', [CoursesController::class, 'saveEdit'])->name('save_edit');
            Route::get('{id}/dashboard', [CoursesController::class, 'viewDashboard'])->name('dashboard');
            Route::get('{id}/materias', [CoursesController::class, 'viewMaterias'])->name('list_materias');
            Route::get('{id}/alumnos', [CoursesController::class, 'viewStudents'])->name('list_students');
            Route::get('{id}/eventos', [CoursesController::class, 'viewEventosById'])->name('list_eventos');
        });

        Route::get('api/cursos', [EventsController::class, 'getCursos']);
        Route::get('api/materias', [EventsController::class, 'getMaterias']);
        Route::get('api/eventos/{id_event}', [EventsController::class, 'getEventByID']);


        // DOCENTES
        Route::group(['prefix' => 'docentes', 'as' => 'docentes.'], function () {
            Route::get('', [ProfesoresController::class, 'index'])->name('index');
            Route::get('new', [ProfesoresController::class, 'showFormNew'])->name('new');
            Route::post('create', [ProfesoresController::class, 'saveNewDocente'])->name('create');
            Route::get('edit/{id_profesor}', [ProfesoresController::class, 'editById'])->name('edit');
            Route::post('save_edit', [ProfesoresController::class, 'saveEdit'])->name('save_edit');
        });
    });
});
