<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

Route::get('/', function () {
    return view('home');
});

Route::get('/struktur-pengurus', function () {
    return view('struktur-pengurus');
});

Route::get('/kegiatan', function () {
    return view('kegiatan');
});
