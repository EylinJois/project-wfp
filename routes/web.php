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

// TODO: Tambahkan routing untuk halaman lain.

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('artikel/db', [ArtikelController::class, 'dbIndex'])->name('dbArtikel');

Route::resource('artikel', ArtikelController::class)->names([
    'index' => 'artikel',
    'show' => 'artikel.show',
    'create' => 'artikel.create',
    'store' => 'artikel.store',
    'edit' => 'artikel.edit',
    'update' => 'artikel.update',
    'destroy' => 'artikel.destroy',
]);
Route::resource('chat', ChatController::class)->names([
    'index' => 'chat',
]);
Route::resource('dokter', DokterController::class)->names([
    'index' => 'doctors',
]);
Route::resource('konsultasi', KonsultasiController::class)->names([
    'index' => 'konsultasi',
]);
Route::resource('member', MemberController::class)->names([
    'index' => 'members',
]);
Route::resource('spesialisasi', SpesialisasiController::class)->names([
    'index' => 'spesialisasi',
]);
Route::resource('user', UserController::class)->names([
    'index' => 'users',
]);
