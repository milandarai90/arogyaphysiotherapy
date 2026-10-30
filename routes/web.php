<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;   
use App\Models\Gallery;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.home');
})->name('about');

Route::get('/services', function () {
    return view('pages.home');
})->name('services');

Route::get('/gallery', function () {
    $galleries = Gallery::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

    return view('pages.gallery', compact('galleries'));
})->name('gallery');

Route::get('/blog', function () {
    return view('pages.home');
})->name('blog');

Route::get('/contact', function () {
    return view('pages.home');
})->name('contact');

// Public Appointment Booking
Route::get('/appointment', [AppointmentController::class, 'create'])
    ->name('appointment.create');

Route::post('/appointment', [AppointmentController::class, 'store'])
    ->name('appointment.store');

Route::get('/appointment/success/{reference}', [AppointmentController::class, 'success'])
    ->name('appointment.success');

    
// Admin Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('admin')
        ->name('logout');

});
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/appointments', [AdminAppointmentController::class, 'index'])
        ->name('admin.appointments.index');

    Route::get('/admin/appointments/{appointment}', [AdminAppointmentController::class, 'show'])
        ->name('admin.appointments.show');

    Route::patch('/admin/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])
        ->name('admin.appointments.status');

    Route::patch('/admin/appointments/{appointment}/reschedule', [AdminAppointmentController::class, 'reschedule'])
        ->name('admin.appointments.reschedule');



        // Service Management
Route::get('/admin/services', [ServiceController::class, 'index'])
    ->name('admin.services.index');

Route::get('/admin/services/create', [ServiceController::class, 'create'])
    ->name('admin.services.create');

Route::post('/admin/services', [ServiceController::class, 'store'])
    ->name('admin.services.store');

Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])
    ->name('admin.services.edit');

Route::put('/admin/services/{service}', [ServiceController::class, 'update'])
    ->name('admin.services.update');

Route::patch('/admin/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])
    ->name('admin.services.toggle');

Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])
    ->name('admin.services.destroy');



    // Gallery Management
Route::get('/admin/gallery', [GalleryController::class, 'index'])
    ->name('admin.gallery.index');

Route::get('/admin/gallery/create', [GalleryController::class, 'create'])
    ->name('admin.gallery.create');

Route::post('/admin/gallery', [GalleryController::class, 'store'])
    ->name('admin.gallery.store');

Route::get('/admin/gallery/{gallery}/edit', [GalleryController::class, 'edit'])
    ->name('admin.gallery.edit');

Route::put('/admin/gallery/{gallery}', [GalleryController::class, 'update'])
    ->name('admin.gallery.update');

Route::patch('/admin/gallery/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])
    ->name('admin.gallery.toggle');

Route::delete('/admin/gallery/{gallery}', [GalleryController::class, 'destroy'])
    ->name('admin.gallery.destroy');
});