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
    Route::post('/chat', [ChatController::class, 'store'])
        ->name('chat.store');
    Route::get('/consultation/indexConsultation', [ConsultationController::class, 'indexConsultation'])
        ->name('consultation.index');
    Route::get('/booking/{doctor}/schedule', [ConsultationController::class, 'showSchedule'])
        ->name('booking.showSchedule');
    Route::post('/consultation/store', [ConsultationController::class, 'store'])
        ->name('booking.store');
    Route::get('/doctor', [DoctorController::class, 'index'])
        ->name('doctor.index');

    Route::middleware('role:member')->group(function () {
        // TODO: Isi routing untuk member.
        // show consultation detail
        Route::get(
            '/consultation/{consultation}',
            [ConsultationController::class, 'show']
        )->name('consultation.show');
        //history consultation
        Route::get(
            '/history',
            [ConsultationController::class, 'history']
        )->name('member.history');
        Route::get(
            '/history/{consultation}',
            [ConsultationController::class, 'historyDetail']
        )->name('member.history.detail');
        // Route::post(
        //     '/chat',
        //     [ChatController::class, 'store']
        // )->name('chat.store');
    });

    Route::middleware('role:doctor')->group(function () {
        // TODO: Isi routing untuk dokter.
        Route::get('/doctor/editProfile', [DoctorController::class, 'editProfile'])
            ->name('doctor.editProfile');
        Route::put('/doctor/updateProfile/{doctor}', [DoctorController::class, 'updateProfile'])
            ->name('doctor.updateProfile');
        Route::get(
            '/doctor/consultation/{consultation}',
            [ConsultationController::class, 'show']
        )->name('doctor.consultation.show');
        Route::get(
            '/doctor/consultations',
            [ConsultationController::class, 'doctorConsultations']
        )->name('doctor.consultations');
        Route::patch(
            '/doctor/consultation/{consultation}/start',
            [ConsultationController::class, 'start']
        )->name('doctor.consultation.start');
        Route::patch(
            '/doctor/consultation/{consultation}/finish',
            [ConsultationController::class, 'finish']
        )->name('doctor.consultation.finish');
        Route::get(
            '/doctor/schedule',
            [ConsultationController::class, 'schedule']
        )->name('doctor.schedule');
        // Route::post(
        //     '/chat',
        //     [ChatController::class, 'store']
        // )->name('doctor.chat.store');
    });

    Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])
        ->name('doctor.show');

    Route::middleware('role:admin')->group(function () {

        Route::post('/doctor/getEditFormB', [DoctorController::class, 'getEditFormB'])
            ->name('doctor.getEditFormB');
        Route::post('/doctor/deleteData', [DoctorController::class, 'deleteData'])
            ->name('doctor.deleteData');
        Route::post('/doctor/saveDataUpdate', [DoctorController::class, 'saveDataUpdate'])
            ->name('doctor.saveDataUpdate');
        Route::get('/doctor/create', [DoctorController::class, 'create'])
            ->name('doctor.create');
        Route::post('/doctor/store', [DoctorController::class, 'store'])
            ->name('doctor.store');
        Route::get('/doctor/{doctor}/edit', [DoctorController::class, 'edit'])
            ->name('doctor.edit');
        Route::put('/doctor/{doctor}', [DoctorController::class, 'update'])
            ->name('doctor.update');
        Route::delete('/doctor/{doctor}', [DoctorController::class, 'destroy'])
            ->name('doctor.destroy');

        Route::get('/artikel', [ArticleController::class, 'memberIndex'])->name('article.member_index');
        Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('article.show');

        Route::resource('admin/article', ArticleController::class)->except(['show']);

        Route::get('/admin/consultation', [ConsultationController::class, 'index'])
            ->name('admin.consultation.index');

        Route::delete('/admin/consultation/{consultation}', [ConsultationController::class, 'destroy'])
            ->name('admin.consultation.destroy');
        Route::resource('member', MemberController::class)->names([
            'index' => 'member',
        ]);
        Route::resource('specialty', SpecialtyController::class)->names([
            'index' => 'specialty',
        ]);
        Route::resource('user', UserController::class)->names([
            'index' => 'user',
        ]);
        Route::post('/user/getEditForm',[UserController::class,'getEditForm'])->name('user.getEditForm');
        });
        Route::post('/user/save-data-update', [UserController::class, 'saveDataUpdate'])->name('user.saveDataUpdate');
        Route::post('/user/deleteData', [UserController::class, 'deleteData'])->name('user.deleteData');
        Route::post('/user/store-ajax', [UserController::class, 'storeAjax'])->name('user.storeAjax');

        Route::get('/members', [MemberController::class, 'index'])->name('member.index');
        Route::post('/members/store-ajax', [MemberController::class, 'storeAjax'])->name('member.storeAjax');
        Route::post('/members/get-edit-form', [MemberController::class, 'getEditForm'])->name('member.getEditForm');
        Route::post('/members/save-update', [MemberController::class, 'saveDataUpdate'])->name('member.saveDataUpdate');
        Route::post('/members/delete', [MemberController::class, 'deleteData'])->name('member.deleteData');
        
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultation.index');
        Route::post('/consultations/store-ajax', [ConsultationController::class, 'storeAjax'])->name('consultation.storeAjax');
        Route::post('/consultations/get-edit-form', [ConsultationController::class, 'getEditForm'])->name('consultation.getEditForm');
        Route::post('/consultations/save-update', [ConsultationController::class, 'saveDataUpdate'])->name('consultation.saveDataUpdate');
        Route::post('/consultations/delete', [ConsultationController::class, 'deleteData'])->name('consultation.deleteData');
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
