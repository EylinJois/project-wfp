<?php

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
    return view('welcome');
});


Route::get('/artikel', function () {
    $data = [
        (object)[
            'id' => 1,
            'judul' => 'Artikel 1',
            'tanggal' => '2024-06-01',
            'isi' => 'Isi artikel 1',
            'foto' => 'foto1.jpg',
            'dokter_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        (object)[
            'id' => 2,
            'judul' => 'Artikel 2',
            'tanggal' => '2024-06-02',
            'isi' => 'Isi artikel 2',
            'foto' => 'foto2.jpg',
            'dokter_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
    return view('artikel', ['data' => $data]);
});