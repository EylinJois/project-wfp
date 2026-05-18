<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SpesialisasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('auth/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('auth/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('auth/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('auth/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('artikel', ArtikelController::class)->names([
        'index' => 'artikel',
        'show' => 'artikel.show',
        'create' => 'artikel.create',
        'store' => 'artikel.store',
        'edit' => 'artikel.edit',
        'update' => 'artikel.update',
        'destroy' => 'artikel.destroy',
    ]);

    Route::middleware('role:member')->group(function () {
        // TODO: Isi routing untuk member.
    });

    Route::middleware('role:dokter')->group(function () {
        // TODO: Isi routing untuk dokter.
    });

    Route::middleware('role:admin')->group(function () {
        // TODO: Isi routing untuk admin.
        Route::get('artikel/db', [ArtikelController::class, 'dbIndex'])->name('dbArtikel');

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
    });
});
