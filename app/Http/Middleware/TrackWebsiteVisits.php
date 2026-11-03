<?php

namespace App\Http\Middleware;

use App\Models\WebsiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteVisits
{
    private const COOKIE_NAME = 'arogya_visitor_id';

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->shouldTrack($request)) {
            return $next($request);
        }

        $visitorToken = $request->cookie(self::COOKIE_NAME);

        if (!$visitorToken || !Str::isUuid($visitorToken)) {
            $visitorToken = (string) Str::uuid();
        }

        $visitorId = hash('sha256', $visitorToken);

        WebsiteVisit::create([
            'page_path' => '/' . ltrim($request->path(), '/'),
            'visitor_id' => $visitorId,
            'visited_at' => now(),
        ]);

        // Update the public counter before the Blade view is rendered.
        Cache::forget('website_total_visits');

        $totalVisits = Cache::remember(
            'website_total_visits',
            now()->addMinutes(5),
            fn () => WebsiteVisit::count()
        );

        View::share('publicTotalVisits', $totalVisits);

        $response = $next($request);

        return $response->withCookie(cookie(
            self::COOKIE_NAME,
            $visitorToken,
            60 * 24 * 365,
            '/',
            null,
            $request->isSecure(),
            true,
            false,
            'lax'
        ));
    }

    private function shouldTrack(Request $request): bool
    {
        if (!$request->isMethod('GET')) {
            return false;
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return false;
        }

        if (!$request->route()) {
            return false;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        if (preg_match(
            '/\.(css|js|png|jpg|jpeg|gif|svg|webp|ico|woff|woff2|ttf|map|pdf)$/i',
            $request->path()
        )) {
            return false;
        }

        $userAgent = strtolower($request->userAgent() ?? '');

        if (preg_match(
            '/bot|crawler|spider|slurp|facebookexternalhit|preview|headless/i',
            $userAgent
        )) {
            return false;
        }

        return true;
    }
}