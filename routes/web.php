<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthController;
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
    return view('layout.app');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::resource('artikel', ArtikelController::class);
Route::resource('chat', ChatController::class);
Route::resource('dokter', DokterController::class);
Route::resource('konsultasi', KonsultasiController::class);
Route::resource('member', MemberController::class);
Route::resource('spesialisasi', SpesialisasiController::class);
Route::resource('user', UserController::class);
