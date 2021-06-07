<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResourcesController;

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

Route::get('/resources/filter/level/{level}', [ResourcesController::class, 'filterByLevel']);
Route::post('/resources/search', [ResourcesController::class, 'search']);
Route::get('/resources/filter/format/{format}', [ResourcesController::class, 'filterByFormat']);
Route::get('/', [ResourcesController::class, 'getData']);

Route::get('/admin/customers-management', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);

Auth::routes();
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/chat', [HomeController::class, 'chat'])->name('chat');
Route::post('pusher/auth', function() {
  return auth()->user();
});
