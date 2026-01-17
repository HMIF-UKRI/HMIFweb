<?php

use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PeriodeKepengurusanController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [OrganizationController::class, 'home'])->name('home');
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('struktur-pengurus');

Route::get('/kegiatan', [EventController::class, 'kegiatan'])->name('kegiatan');
Route::get('/event', [EventController::class, 'index'])->name('events.index');
Route::get('/event/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::resource('blog', BlogController::class);

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Dashboard & Profile)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Halaman Dashboard Umum
    Route::get('/dashboard', function () {
        return view('page.dashboard');
    })->name('dashboard');

    // Profile Management (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin & Pengurus Routes (Role: super-admin, pengurus)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:super-admin|pengurus'])->prefix('admin')->name('admin.')->group(function () {

        // Master Data (Hanya Super Admin)
        Route::middleware(['role:super-admin'])->group(function () {
            Route::resource('departments', DepartemenController::class);
            Route::resource('bidangs', BidangController::class);
            Route::resource('periods', PeriodeKepengurusanController::class);
            Route::resource('members', MemberController::class);
            Route::resource('generations', AngkatanController::class);
        });

        // Manajemen Organisasi & Konten
        Route::resource('managements', PengurusController::class);
        Route::resource('events', EventController::class)->except(['index', 'show']);

        // Manajemen Absensi
        Route::get('events/{event}/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('events/{event}/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('events/{event}/attendances/report', [AttendanceController::class, 'report'])->name('attendances.report');
    });

    /*
    |--------------------------------------------------------------------------
    | Member Fitur (Role: anggota)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:anggota'])->prefix('member')->name('member.')->group(function () {
        Route::resource('portofolios', PortofolioController::class);
    });
});

require __DIR__ . '/auth.php';
