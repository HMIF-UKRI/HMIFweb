<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminMerchandiseController;
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
use App\Http\Controllers\PublicMerchandiseController;
use App\Http\Controllers\PublicPortofolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [OrganizationController::class, 'home'])->name('home');
Route::get('/struktur-pengurus', [OrganizationController::class, 'index'])->name('struktur-pengurus');

Route::get('/absensi/kegiatan/{slug}', [AttendanceController::class, 'processScan'])->name('attendance.scan');
Route::post('/absensi/submit/{slug}', [AttendanceController::class, 'store'])->name('attendance.submit');

Route::get('/kegiatan/{slug}', [PublicEventController::class, 'show'])->name('event.show');
Route::get('/kegiatan', [PublicEventController::class, 'index'])->name('event.index');

Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])->name('blog.show');

Route::get('/portofolio', [PublicPortofolioController::class, 'index'])->name('portofolio.index');
Route::get('/portofolio/{slug}', [PublicPortofolioController::class, 'show'])->name('portofolio.show');

Route::get('/aspirasi', [OrganizationController::class, 'aspirasi'])->name('aspirasi');

Route::get('/merchandise', [PublicMerchandiseController::class, 'index'])->name('merchandise');

Route::get('/cooming-soon', [OrganizationController::class, 'comingsoon'])->name('coming-soon');


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
            Route::resource('merchandises', AdminMerchandiseController::class);

            Route::patch('merchandises/{merchandise}/increment', [AdminMerchandiseController::class, 'incrementStock'])->name('merchandises.increment');
            Route::patch('merchandises/{merchandise}/decrement', [AdminMerchandiseController::class, 'decrementStock'])->name('merchandises.decrement');
        });

        // Manajemen Organisasi & Konten
        Route::resource('managements', PengurusController::class);
        Route::resource('events', AdminEventController::class);
        Route::post('/events/upload-image', [AdminEventController::class, 'uploadImage'])->name('events.upload-image');
        Route::resource('galleries', GalleriesController::class);
        Route::resource('blogs', AdminBlogController::class);
        Route::post('/blogs/upload-image', [AdminBlogController::class, 'uploadImage'])->name('blogs.upload-image');
        Route::resource('doc-event', DocEventController::class);

        // Manajemen Absensi
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('attendances/absensi/{slug}', [AttendanceController::class, 'absensi'])->name('attendances.absensi');
        Route::get('attendances/qrcode/{slug}', [AttendanceController::class, 'showQrCode'])
            ->name('attendances.qrcode');
        Route::post('events/{event_id}/attendance/manual', [AttendanceController::class, 'storeManual'])->name('attendance.manual');
        Route::get('attendances/{slug}/export-pdf', [AttendanceController::class, 'exportPdf'])
            ->name('attendances.export_pdf');
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
