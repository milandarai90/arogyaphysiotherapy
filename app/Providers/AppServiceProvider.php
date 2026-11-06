<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\Blog;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('admin-login', function (Request $request) {
            $email = strtolower((string) $request->input('email'));

            return [
                Limit::perMinute(5)->by('login-email:'.$email.'|'.$request->ip()),
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('appointment-submit', fn (Request $request) =>
            Limit::perMinute(5)->by($request->ip())
        );

        RateLimiter::for('appointment-slots', fn (Request $request) =>
            Limit::perMinute(60)->by($request->ip())
        );

        RateLimiter::for('appointment-status-check', fn (Request $request) =>
            Limit::perMinute(10)->by($request->ip())
        );

        RateLimiter::for('admin-password-change', fn (Request $request) =>
            Limit::perMinute(5)->by((string) $request->user()?->getAuthIdentifier())
        );

        View::composer(['layouts.app', 'pages.home'], function ($view) {

            $settings = Setting::all()->keyBy('key');

            $services = Service::where('is_active', true)
                ->latest()
                ->take(6)
                ->get();

            $gallery = Gallery::where('is_active', true)
                ->orderBy('sort_order')
                ->latest()
                ->take(6)
                ->get();

            $blogs = Blog::where('is_published', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->latest('published_at')
                ->take(3)
                ->get();

            $view->with('siteSettings', $settings);
            $view->with('homeServices', $services);
            $view->with('homeGallery', $gallery);
            $view->with('homeBlogs', $blogs);

        });
    }
}
