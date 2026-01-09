<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\EventCategory;

Route::get('/', [OrganizationController::class, 'home'])->name('home');

// Struktur Pengurus
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('organization.index');

// Kegiatan
Route::get('/kegiatan', function () {
    $events = Event::with('eventCategory')->get();
    $statusEvent = Event::where('status')->get();

    $eventCategories = EventCategory::all();

    return view('page.kegiatan', compact('events', 'eventCategories', 'statusEvent'));
});

Route::resource('event', EventController::class);
Route::resource('member', MemberController::class);
