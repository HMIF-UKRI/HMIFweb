<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventnController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

Route::get('/', function () {
    return view('home');
});

// Struktur Pengurus
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('organization.index');

// Kegiatan
Route::get('/kegiatan', [EventController::class, 'index'])->name('event.index');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('event.show');


Route::resource('event', EventController::class);
Route::resource('member', MemberController::class);
