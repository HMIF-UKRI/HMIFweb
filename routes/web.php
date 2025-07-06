<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Member;

Route::get('/', function () {
    $events = Event::latest()->take(3)->get();
    $members = Member::latest()->take(4)->get();
    return view('page.home', compact('members', 'events'));
});

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
