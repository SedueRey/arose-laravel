<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RubricController;

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
Route::get('/', [ResourcesController::class, 'getData']);
Route::get('/resources', [ResourcesController::class, 'getData'])->name('resources');
Route::get('/resources/filter/{format}/{level}', [ResourcesController::class, 'filterByAll']);
Route::get('/resources/arose', [ResourcesController::class, 'filterArose']);

/*
Route::get('/admin/customers-management', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
*/

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/resources/mine', [ResourcesController::class, 'mine']);
    Route::get('/resources/new', [ResourcesController::class, 'create'])->name('createResource');
    Route::post('/resources/store', [ResourcesController::class, 'store'])->name('storeResource');
    Route::get('/resources/edit/{id}', [ResourcesController::class, 'edit'])->name('editResource');
    Route::post('/resources/update/{id}', [ResourcesController::class, 'update'])->name('updateResource');
    Route::delete('/resources/delete/{id}', [ResourcesController::class, 'destroy'])->name('destroyResource');

    Route::get('/rubrics', [RubricController::class, 'index'])->name('rubrics');
    Route::get('/rubrics/show/{id}', [RubricController::class, 'show'])->name('showRubric');
    Route::get('/rubrics/new', [RubricController::class, 'create'])->name('createRubric');
    Route::post('/rubrics/store', [RubricController::class, 'store'])->name('storeRubric');
    Route::get('/rubrics/edit/{id}', [RubricController::class, 'edit'])->name('editRubric');
    Route::get('/rubrics/duplicate/{id}', [RubricController::class, 'duplicate'])->name('duplicateRubric');
    Route::post('/rubrics/update/{id}', [RubricController::class, 'update'])->name('updateRubric');
    Route::get('/rubrics/delete/{id}', [RubricController::class, 'destroy'])->name('deleteRubric');

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

    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/students/new', [StudentController::class, 'create'])->name('newstudent');
    Route::post('/students/newaction', [StudentController::class, 'store'])->name('createStudent');
    Route::get('/students/edit/{uuid}', [StudentController::class, 'edit'])->name('editStudent');
    Route::post('/students/update/{uuid}', [StudentController::class, 'update'])->name('updateStudent');

});
