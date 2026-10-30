<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

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
    return view('pages.home');
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
