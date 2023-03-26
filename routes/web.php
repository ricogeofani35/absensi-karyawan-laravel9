<?php

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

// Route::get('/', function () {
//     return view('layouts.admin');
// });

// ------------------------------------------
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AbsensiController;

Route::view('/', 'auth.login');
Route::view('/home', 'admins.dashboard.dashboard');

Route::resource('/karyawan', KaryawanController::class);
Route::get('/api/karyawan', [KaryawanController::class, 'api']);
Route::resource('/absensi', AbsensiController::class);
Route::resource('/laporan', LaporanController::class);
Route::get('/api/laporan', [LaporanController::class, 'api']);




Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
