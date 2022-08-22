<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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


// Route::match(['get', 'post'],'/', [AuthController::class,'register'])->name('signup')->middleware('login');
// Route::match(['get', 'post'],'/login', [AuthController::class,'login'])->name('login')->middleware('login');


Route::match(['get', 'post'],'/', [AuthController::class,'register'])->name('signup')->middleware('login');
Route::match(['get', 'post'],'/login', [AuthController::class,'login'])->name('login')->middleware('login');

Route::group(['middleware'=>'user'], function() {
    Route::post('/todo/add',[TaskController::class,'insertTask'])->name('add');
    Route::post('/todo/status',[TaskController::class,'status'])->name('status');
    Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');
    Route::get('/getData', [AuthController::class,'getData'])->name('getData');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});



