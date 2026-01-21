<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminPortofolioController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DocEventController;
use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PeriodeKepengurusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\PublicPortofolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [OrganizationController::class, 'home'])->name('home');
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('struktur-pengurus');

Route::get('/kegiatan', [PublicEventController::class, 'index'])->name('event.index');
Route::get('/kegiatan/{slug}', [PublicEventController::class, 'show'])->name('event.show');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/portofolio', [PublicPortofolioController::class, 'index'])->name('portofolio.index');
Route::get('/portofolio/{slug}', [PublicPortofolioController::class, 'show'])->name('portofolio.show');


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
        Route::middleware(['role:super-admin|pengurus'])->group(function () {
            Route::resource('departments', DepartemenController::class);
            Route::resource('bidangs', BidangController::class);
            Route::resource('periods', PeriodeKepengurusanController::class);
            Route::resource('members', MemberController::class);
            Route::resource('generations', AngkatanController::class);
            Route::resource('categories', CategoriesController::class);
        });

        // Manajemen Organisasi & Konten
        Route::resource('managements', PengurusController::class);
        Route::resource('events', AdminEventController::class);
        Route::resource('galleries', GalleriesController::class);
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('doc-event', DocEventController::class);

        // Manajemen Absensi
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('events/{event}/attendances', [AttendanceController::class, 'absen'])->name('attendances.absen');
        Route::post('events/{event}/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('events/{event}/attendances/report', [AttendanceController::class, 'report'])->name('attendances.report');
    });

    /*
    |--------------------------------------------------------------------------
    | Member Fitur (Role: anggota)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:super-admin|pengurus|anggota'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('portofolios', AdminPortofolioController::class);
    });
});

require __DIR__ . '/auth.php';
