<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
