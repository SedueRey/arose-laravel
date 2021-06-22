<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\StudentController;

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
Route::get('/resources/mine', [ResourcesController::class, 'mine']);
Route::get('/', [ResourcesController::class, 'getData']);
Route::get('/resources', [ResourcesController::class, 'getData']);
Route::get('/resources/filter/{format}/{level}', [ResourcesController::class, 'filterByAll']);

/*
Route::get('/admin/customers-management', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
*/

Auth::routes();
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

Route::get('/avatar', [HomeController::class, 'avatar'])->name('avatar');

Route::get('/students', [StudentController::class, 'index'])->name('students');
Route::get('/students/new', [StudentController::class, 'create'])->name('newstudent');
Route::post('/students/newaction', [StudentController::class, 'store'])->name('createStudent');
Route::get('/students/edit/{uuid}', [StudentController::class, 'edit'])->name('editStudent');
Route::post('/students/update/{uuid}', [StudentController::class, 'update'])->name('updateStudent');
