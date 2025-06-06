<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventnController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Models\Event;
use App\Models\Member;

Route::get('/', function () {
    $events = Event::latest()->take(3)->get();
    $members = Member::latest()->take(3)->get();
    return view('home', compact('members', 'events'));
});

// Struktur Pengurus
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('organization.index');

// Kegiatan
Route::get('/kegiatan', [EventController::class, 'index'])->name('event.index');
Route::get('/kegiatan/{slug}', [EventController::class, 'show'])->name('event.show');


Route::resource('event', EventController::class);
Route::resource('member', MemberController::class);
