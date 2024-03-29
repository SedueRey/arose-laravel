<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\PublicResources;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\GradebookController;
use App\Http\Controllers\ImportStudentsController;
use App\Http\Controllers\PanelAroseController;
use App\Http\Controllers\StatsController;
use App\Http\Middleware\VerifyCsrfToken;

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

Route::post('/resources/search', [ResourcesController::class, 'search']);
Route::get('/resources/search', function() {
    return redirect('/resources');
});
Route::get('/', [ResourcesController::class, 'getIndex']);
Route::get('/resources', [ResourcesController::class, 'getData'])->name('resources');
Route::get('/resources/filter/{format}/{level}', [ResourcesController::class, 'filterByAll']);
Route::get('/resources/arose', [ResourcesController::class, 'filterArose']);
Route::get('/resources/public', [PublicResources::class, 'index'])->name('publicresources');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/resources/mine', [ResourcesController::class, 'mine']);
    Route::get('/resources/new', [ResourcesController::class, 'create'])->name('createResource');
    Route::post('/resources/store', [ResourcesController::class, 'store'])->name('storeResource');
    Route::get('/resources/edit/{id}', [ResourcesController::class, 'edit'])->name('editResource');
    Route::post('/resources/update/{id}', [ResourcesController::class, 'update'])->name('updateResource');
    Route::delete('/resources/delete/{id}', [ResourcesController::class, 'destroy'])->name('destroyResource');

    Route::get('/aroserubrics', [RubricController::class, 'arose'])->name('aroserubrics');
    Route::get('/sharedrubrics', [RubricController::class, 'sharedrubrics'])->name('sharedrubrics');
    Route::get('/rubrics', [RubricController::class, 'index'])->name('rubrics');
    Route::get('/rubrics/show/{id}', [RubricController::class, 'show'])->name('showRubric');
    Route::get('/rubrics/new', [RubricController::class, 'create'])->name('createRubric');
    Route::post('/rubrics/store', [RubricController::class, 'store'])->name('storeRubric');
    Route::get('/rubrics/edit/{id}', [RubricController::class, 'edit'])->name('editRubric');
    Route::get('/rubrics/duplicate/{id}', [RubricController::class, 'duplicate'])->name('duplicateRubric');
    Route::post('/rubrics/update/{id}', [RubricController::class, 'update'])->name('updateRubric');
    Route::get('/rubrics/delete/{id}', [RubricController::class, 'destroy'])->name('deleteRubric');

    /* Gradebook */
    Route::group(['prefix' => 'gradebook'], function() {
        // API
        Route::group(['prefix' => 'api'], function() {
            Route::get('myself', [GradebookController::class, 'myself']);
            Route::get('myrubrics', [GradebookController::class, 'myrubrics']);
            Route::get('myusedrubrics', [GradebookController::class, 'myusedrubrics']);
            Route::get('mystudents', [GradebookController::class, 'mystudents']);
            Route::get('aroserubrics', [GradebookController::class, 'aroserubrics']);
            Route::post('setuserusedrubric', [GradebookController::class, 'setuserusedrubric'])
                ->withoutMiddleware([VerifyCsrfToken::class]);
            Route::post('removeuserusedrubric', [GradebookController::class, 'removeuserusedrubric'])
                ->withoutMiddleware([VerifyCsrfToken::class]);
            Route::post('setuserstudentusedrrating', [GradebookController::class, 'setuserstudentusedrrating'])
                ->withoutMiddleware([VerifyCsrfToken::class]);
            Route::post('removeuserstudentusedrrating', [GradebookController::class, 'removeuserstudentusedrrating'])
                ->withoutMiddleware([VerifyCsrfToken::class]);
        });
        // Controladores / Vistas
        Route::get('/', [GradebookController::class, 'index']);
        Route::get('config', [GradebookController::class, 'config']);
        Route::get('excel', [GradebookController::class, 'excel']);
        Route::get('stats', [StatsController::class, 'index']);
        Route::get('summary', [StatsController::class, 'excel']);
    });

    /* End gradebook */

    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/chat', [HomeController::class, 'chat'])->name('chat');
    Route::post('pusher/auth', function() {
        return auth()->user();
    });

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profilephoto', [HomeController::class, 'profilephoto'])->name('profilephoto');
    Route::post('/profileuser', [HomeController::class, 'profileuser'])->name('profileuser');
    Route::get('/admin/clear-cache', function() {
        if (Auth()->user()->isadmin == true) {
            Artisan::call('optimize:clear');
            return "Cache is cleared";
        } else {
            return "Cache is cleared?";
        }
    });
    Route::get('/symlink', function() {
        if (Auth()->user()->isadmin == true) {
            Artisan::call('storage:link');
            return "storage ok";
        } else {
            return "storage ?: ok";
        }
    });

    Route::get('/arose/stats', [PanelAroseController::class, 'stats'])->name('stats');

    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/students/new', [StudentController::class, 'create'])->name('newstudent');
    Route::post('/students/newaction', [StudentController::class, 'store'])->name('createStudent');
    Route::get('/students/edit/{uuid}', [StudentController::class, 'edit'])->name('editStudent');
    Route::post('/students/update/{uuid}', [StudentController::class, 'update'])->name('updateStudent');
    Route::get('/students/delete/{uuid}', [StudentController::class, 'delete'])->name('deleteStudent');

    Route::get('/students/import', [ImportStudentsController::class, 'firstStep'])->name('importStudentStep1');
    Route::get('/students/importok', [ImportStudentsController::class, 'importok'])->name('importok');
    Route::post('/students/showlist', [ImportStudentsController::class, 'showListUploaded'])->name('showListUploaded');
    Route::post('/students/api/addimport', [ImportStudentsController::class, 'addImportStudent'])
        ->name('addImportStudent')
        ->withoutMiddleware([VerifyCsrfToken::class]);
});
