<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('customer', [CustomerController::class, 'index']);
Route::post('add-update-customer', [CustomerController::class, 'store']);
Route::post('edit-customer', [CustomerController::class, 'edit']);
Route::post('delete-customer', [CustomerController::class, 'destroy']);

Route::get('bill', [BillController::class, 'index']);
Route::post('add-update-bill', [BillController::class, 'store']);
Route::post('edit-bill', [BillController::class, 'edit']);
Route::post('delete-bill', [BillController::class, 'destroy']);
