
<?php

use Illuminate\Support\Facades\Route;

use App\Models\Gallery;

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\AppointmentStatusController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\GalleryController;
use App\Models\Setting;
use App\Http\Controllers\Admin\OperatingHourController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;


/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $siteSettings = \App\Models\Setting::all()->keyBy('key');

    // Services
    $homeServices = \App\Models\Service::where('is_active', true)
        ->orderBy('name')
        ->take(6)
        ->get();

    // Gallery
    $homeGallery = \App\Models\Gallery::where('is_active', true)
        ->orderBy('sort_order')
        ->latest()
        ->take(6)
        ->get();

    // Published blog posts
    $homeBlogs = \App\Models\Blog::where('is_published', true)
        ->where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
        ->latest('published_at')
        ->take(3)
        ->get();

    // Therapists
    $therapists = \App\Models\Therapist::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    // Testimonials
    $testimonials = \App\Models\Testimonial::where('is_active', true)
        ->orderBy('sort_order')
        ->latest()
        ->take(6)
        ->get();

    // Weekly operating hours
    $operatingHours = \App\Models\OperatingHour::orderByRaw("
        FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday',
        'Thursday', 'Friday', 'Saturday', 'Sunday')
    ")->get();

    // Upcoming holidays
    $upcomingHolidays = \App\Models\Holiday::whereDate(
        'holiday_date', '>=', today()
    )->orderBy('holiday_date')
        ->take(5)
        ->get();

    return view('pages.home', compact(
        'siteSettings',
        'homeServices',
        'homeGallery',
        'homeBlogs',
        'therapists',
        'testimonials',
        'operatingHours',
        'upcomingHolidays'
    ));
})->name('home');


Route::get('/about', function () {
    $siteSettings = Setting::all()->keyBy('key');

    $therapists = \App\Models\Therapist::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();

    return view('pages.about', compact('siteSettings', 'therapists'));
})->name('about');
Route::get('/services', function () {
    $siteSettings = \App\Models\Setting::all()->keyBy('key');

    $services = \App\Models\Service::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('pages.services', compact('siteSettings', 'services'));
})->name('services');

Route::get('/gallery', function () {
    $galleries = Gallery::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

    return view('pages.gallery', compact('galleries'));
})->name('gallery');

// Public Blog
Route::get('/blog', [BlogController::class, 'index'])
    ->name('blog');

Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->name('blog.show');

Route::get('/contact', function () {
    $siteSettings = \App\Models\Setting::all()->keyBy('key');

    $operatingHours = \App\Models\OperatingHour::orderByRaw("
        FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday',
        'Thursday', 'Friday', 'Saturday', 'Sunday')
    ")->get();

    $upcomingHolidays = \App\Models\Holiday::whereDate(
        'holiday_date', '>=', today()
    )->orderBy('holiday_date')->get();

    return view('pages.contact', compact(
        'siteSettings',
        'operatingHours',
        'upcomingHolidays'
    ));
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Public Appointment Booking
|--------------------------------------------------------------------------
*/

Route::get('/appointment', [AppointmentController::class, 'create'])
    ->name('appointment.create');

Route::post('/appointment', [AppointmentController::class, 'store'])
    ->name('appointment.store');

Route::get('/appointment/success/{reference}', [AppointmentController::class, 'success'])
    ->name('appointment.success');

Route::get('/appointment-status', [AppointmentStatusController::class, 'index'])
    ->name('appointment.status');

Route::post('/appointment-status', [AppointmentStatusController::class, 'check'])
    ->middleware('throttle:10,1')
    ->name('appointment.status.check');
/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Admin Dashboard and Management
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

// Admin Profile
Route::get('/admin/profile', [ProfileController::class, 'edit'])
    ->name('admin.profile.edit');

Route::put('/admin/profile', [ProfileController::class, 'update'])
    ->name('admin.profile.update');

Route::put('/admin/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('admin.profile.password');

Route::delete('/admin/profile/photo', [ProfileController::class, 'removePhoto'])
    ->name('admin.profile.photo.remove');
    
    // Appointment Management
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


    // Blog Management
    Route::get('/admin/blog', [AdminBlogController::class, 'index'])
        ->name('admin.blog.index');

    Route::get('/admin/blog/create', [AdminBlogController::class, 'create'])
        ->name('admin.blog.create');

    Route::post('/admin/blog', [AdminBlogController::class, 'store'])
        ->name('admin.blog.store');

    Route::get('/admin/blog/{blog}/edit', [AdminBlogController::class, 'edit'])
        ->name('admin.blog.edit');

    Route::put('/admin/blog/{blog}', [AdminBlogController::class, 'update'])
        ->name('admin.blog.update');

    Route::patch('/admin/blog/{blog}/toggle-status', [AdminBlogController::class, 'toggleStatus'])
        ->name('admin.blog.toggle');

    Route::delete('/admin/blog/{blog}', [AdminBlogController::class, 'destroy'])
        ->name('admin.blog.destroy');



// Contact Messages
Route::get('/contact-messages', [ContactMessageController::class, 'index'])
    ->name('admin.contact-messages.index');

Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])
    ->name('admin.contact-messages.show');

Route::put('/contact-messages/{contactMessage}', [ContactMessageController::class, 'update'])
    ->name('admin.contact-messages.update');

Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])
    ->name('admin.contact-messages.destroy');


    // therapist Management

    Route::get('/therapists', [TherapistController::class, 'index'])
    ->name('admin.therapists.index');

Route::get('/therapists/create', [TherapistController::class, 'create'])
    ->name('admin.therapists.create');

Route::post('/therapists', [TherapistController::class, 'store'])
    ->name('admin.therapists.store');

Route::get('/therapists/{therapist}/edit', [TherapistController::class, 'edit'])
    ->name('admin.therapists.edit');

Route::put('/therapists/{therapist}', [TherapistController::class, 'update'])
    ->name('admin.therapists.update');

Route::patch('/therapists/{therapist}/toggle-status', [TherapistController::class, 'toggleStatus'])
    ->name('admin.therapists.toggle');

Route::delete('/therapists/{therapist}', [TherapistController::class, 'destroy'])
    ->name('admin.therapists.destroy');

// testimonial management

    Route::get('/testimonials', [TestimonialController::class, 'index'])
    ->name('admin.testimonials.index');

Route::get('/testimonials/create', [TestimonialController::class, 'create'])
    ->name('admin.testimonials.create');

Route::post('/testimonials', [TestimonialController::class, 'store'])
    ->name('admin.testimonials.store');

Route::get('/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])
    ->name('admin.testimonials.edit');

Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])
    ->name('admin.testimonials.update');

Route::patch('/testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])
    ->name('admin.testimonials.toggle');

Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])
    ->name('admin.testimonials.destroy');


    // Operating Hours Management
    Route::get('/operating-hours', [OperatingHourController::class, 'index'])
    ->name('admin.operating-hours.index');

Route::put('/operating-hours', [OperatingHourController::class, 'updateHours'])
    ->name('admin.operating-hours.update');

Route::post('/holidays', [OperatingHourController::class, 'storeHoliday'])
    ->name('admin.holidays.store');

Route::delete('/holidays/{holiday}', [OperatingHourController::class, 'destroyHoliday'])
    ->name('admin.holidays.destroy');



// Website Settings
Route::get('/admin/settings', [SettingController::class, 'index'])
    ->name('admin.settings.index');

Route::put('/admin/settings', [SettingController::class, 'update'])
    ->name('admin.settings.update');
});


Route::get('/appointment-available-slots', [
    \App\Http\Controllers\AppointmentController::class,
    'availableSlots'
])->name('appointment.available-slots');