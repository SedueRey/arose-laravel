<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroceryController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/customers-management', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::get('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}', [GroceryController::class, 'users']);
Route::post('/admin/customers-management/{operation}/{id}', [GroceryController::class, 'users']);
