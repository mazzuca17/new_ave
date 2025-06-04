<?php

use App\Http\Controllers\Admin\SchoolsController as AdminSchoolsController;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Schools\HomeController as SchoolsHomeController;
use App\Http\Controllers\Schools\EventsController;
use App\Http\Controllers\Schools\CoursesController;
use App\Http\Controllers\Schools\ProfesoresController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\School\OrientacionCursosController;
use App\Http\Controllers\Schools\AlumnosController as SchoolsAlumnosController;
use App\Http\Controllers\Schools\CiclosLectivosController;
use App\Http\Controllers\Schools\MateriasController;
use App\Http\Controllers\Teachers\HomeController;

Route::get('/', [Home::class, 'index'])->name('home');


Auth::routes();



// Rutas con autenticación y roles
Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::group(['prefix' => 'mensajes', 'as' => 'mensajes.'], function () {
        Route::get('', [EmailController::class, 'index'])->name('index'); // Lista de mensajes
        Route::get('crear', [EmailController::class, 'create'])->name('create'); // Crear mensaje
        Route::post('enviar', [EmailController::class, 'send'])->name('send'); // Enviar mensaje
        Route::get('enviados', [EmailController::class, 'sent'])->name('enviados'); // 🔄 Mover aquí
        Route::post('{id}/reply', [EmailController::class, 'reply'])->name('reply');
        Route::get('{id_mensaje}', [EmailController::class, 'show'])->name('show'); // Ver mensaje
        Route::get('enviados/{id_mensaje}', [EmailController::class, 'show_sent'])->name('show_sent'); // Ver mensaje

        Route::delete('{id_mensaje}', [EmailController::class, 'destroy'])->name('destroy'); // Eliminar mensaje
    });


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
        Route::prefix('ciclos')->as('ciclos.')->group(function () {
            Route::get('', [CiclosLectivosController::class, 'index'])->name('dashboard');
            Route::get('create', [CiclosLectivosController::class, 'create'])->name('create');
            Route::post('store', [CiclosLectivosController::class, 'store'])->name('store');
            Route::get('data', [CiclosLectivosController::class, 'getData'])->name('data');
        });

        Route::get('dashboard', [SchoolsHomeController::class, 'index'])->name('dashboard');

        // Eventos
        Route::prefix('eventos')->as('events.')->group(function () {
            Route::get('create', [EventsController::class, 'create'])->name('create');
            Route::post('store', [EventsController::class, 'store'])->name('store');
            Route::get('edit/{event_id}', [EventsController::class, 'edit'])->name('edit');
            Route::post('update', [EventsController::class, 'update'])->name('update');
            Route::get('list', [EventsController::class, 'viewAll'])->name('view');
            Route::put('update-event/{event_id}', [EventsController::class, 'updateEventByID'])->name('update_by_id');
            Route::delete('delete-event/{event_id}', [EventsController::class, 'deleteEventByID'])->name('delete_by_id');
        });

        // Materias
        Route::prefix('materias')->as('materias.')->group(function () {
            Route::get('', [MateriasController::class, 'index'])->name('index');
            Route::get('create', [MateriasController::class, 'create'])->name('create');
            Route::post('store', [MateriasController::class, 'store'])->name('store');
            Route::get('edit/{id_materia}', [MateriasController::class, 'showFormEdit'])->name('edit');
            Route::post('save_edit', [MateriasController::class, 'saveEdit'])->name('save_edit');
        });

        // Cursos
        Route::prefix('courses')->as('courses.')->group(function () {
            Route::get('', [CoursesController::class, 'index'])->name('index');
            Route::get('data', [CoursesController::class, 'getData'])->name('data');
            Route::get('new', [CoursesController::class, 'showFormNew'])->name('new');
            Route::post('create', [CoursesController::class, 'saveNewCourse'])->name('create');
            Route::get('edit/{id_curso}', [CoursesController::class, 'showFormEdit'])->name('edit');
            Route::post('save_edit', [CoursesController::class, 'saveEdit'])->name('save_edit');
            Route::delete('delete/{id}', [CoursesController::class, 'destroy'])->name('school.courses.destroy');

            // ORIENTACIONES - MODALIDADES
            Route::prefix('orientation')->as('orientation.')->group(function () {
                Route::get('', [OrientacionCursosController::class, 'index'])->name('index');
                Route::get('getData', [OrientacionCursosController::class, 'getData'])->name('data');

                Route::get('new', [OrientacionCursosController::class, 'create'])->name('create');
                Route::post('store', [OrientacionCursosController::class, 'store'])->name('store');
                Route::get('edit/{id}', [OrientacionCursosController::class, 'showEditForm'])->name('edit');
                Route::post('save_edit', [OrientacionCursosController::class, 'saveEdit'])->name('save_edit');
            });



            Route::get('{id}/dashboard', [CoursesController::class, 'viewDashboard'])->name('dashboard');
            Route::get('{id}/materias', [CoursesController::class, 'viewMaterias'])->name('list_materias');
            Route::get('{id}/alumnos', [CoursesController::class, 'viewStudents'])->name('list_students');
            Route::get('{id}/eventos', [CoursesController::class, 'viewEventosById'])->name('list_eventos');
        });

        Route::group(['prefix' => 'alumnos', 'as' => 'alumnos.'], function () {
            Route::get('', [SchoolsAlumnosController::class, 'index'])->name('index');
            Route::get('data', [SchoolsAlumnosController::class, 'getData'])->name('data');
            Route::get('new', [SchoolsAlumnosController::class, 'showFormNew'])->name('new');
            Route::post('create', [SchoolsAlumnosController::class, 'store'])->name('create');
            Route::get('edit/{id_alumno}', [SchoolsAlumnosController::class, 'showFormEdit'])->name('edit');
            Route::post('save_edit', [SchoolsAlumnosController::class, 'saveEdit'])->name('save_edit');
            Route::delete('delete/{id}', [SchoolsAlumnosController::class, 'destroy'])->name('destroy');
            Route::get('{id_alumno}', [SchoolsAlumnosController::class, 'showProfile'])->name('profile');
        });


        Route::get('api/cursos', [EventsController::class, 'getCursos']);
        Route::get('api/materias', [EventsController::class, 'getMaterias']);
        Route::get('api/eventos/{id_event}', [EventsController::class, 'getEventByID']);


        // DOCENTES
        Route::group(['prefix' => 'docentes', 'as' => 'docentes.'], function () {
            Route::get('', [ProfesoresController::class, 'index'])->name('index');
            Route::get('data', [ProfesoresController::class, 'getData'])->name('data');
            Route::delete('delete/{id}', [ProfesoresController::class, 'destroy'])->name('destroy');

            Route::get('new', [ProfesoresController::class, 'showFormNew'])->name('new');
            Route::post('create', [ProfesoresController::class, 'saveNewDocente'])->name('create');
            Route::get('edit/{id_profesor}', [ProfesoresController::class, 'showFormEdit'])->name('edit');
            Route::post('save_edit', [ProfesoresController::class, 'saveEdit'])->name('save_edit');
            Route::get('{id_profesor}', [ProfesoresController::class, 'showProfile'])->name('profile');
        });

        // Rutas de mensajería

    });

    Route::middleware('role:Docente')->namespace('Docente')->prefix('docente')->as('docente.')->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    });


    Route::middleware('role:Padres')->namespace('Padres')->prefix('padres')->as('padres.')->group(function () {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    });
});
