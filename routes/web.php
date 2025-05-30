<?php

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
Route::get('/kegiatan', [EventController::class, 'index'])->name('events.index');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('events.show');

Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Kegiatan (Admin)
    Route::resource('events', EventController::class);

    // Anggota (Admin)
    Route::resource('members', MemberController::class);
});
