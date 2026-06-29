<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('auth/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('auth/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('auth/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('auth/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {

    Route::middleware(['auth', 'role:member,admin'])->group(function () {
        Route::resource('doctor', DoctorController::class)
            ->names([
                'index' => 'doctor.index',
                'create' => 'doctor.create',
                'store' => 'doctor.store',
                'edit' => 'doctor.edit',
                'getEditFormB' => 'doctor.getEditFormB',
                'show' => 'doctor.show',
                'update' => 'doctor.update',
                'destroy' => 'doctor.destroy',
            ]);
    });

    Route::middleware('role:member')->group(function () {
        // TODO: Isi routing untuk member.

    });

    Route::middleware('role:doctor')->group(function () {
        // TODO: Isi routing untuk dokter.
    });

    Route::middleware('role:admin')->group(function () {
        // TODO: Isi routing untuk admin.
        Route::post('/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])
            ->name('doctor.getEditFormB');
        Route::post('/doctor/deleteData', [DoctorController::class, 'deleteData'])->name('doctor.deleteData');

        
        Route::get('article/db', [ArticleController::class, 'dbIndex'])->name('dbArticle');

        Route::resource('chat', ChatController::class)->names([
            'index' => 'chat',
        ]);
        Route::resource('consultation', ConsultationController::class)->names([
            'index' => 'consultation',
        ]);
        Route::resource('member', MemberController::class)->names([
            'index' => 'member',
        ]);
        Route::resource('specialty', SpecialtyController::class)->names([
            'index' => 'specialty',
        ]);
        Route::resource('user', UserController::class)->names([
            'index' => 'user',
        ]);
    });

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // TODO: Ini dipindahkan soalnya routing article/db bisa salah kebaca sama laravelnya. 
    Route::resource('article', ArticleController::class)->names([
        'index' => 'article.index',
        'show' => 'article.show',
        'create' => 'article.create',
        'store' => 'article.store',
        'edit' => 'article.edit',
        'update' => 'article.update',
        'destroy' => 'article.destroy',
    ]);
});
