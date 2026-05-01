<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SpesialisasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('artikel', ArtikelController::class);
Route::resource('chat', ChatController::class);
Route::resource('dokter', DokterController::class);
Route::resource('konsultasi', KonsultasiController::class);
Route::resource('member', MemberController::class);
Route::resource('spesialisasi', SpesialisasiController::class);
Route::resource('user', UserController::class);
