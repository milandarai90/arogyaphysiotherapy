<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'choice' => ['required', 'in:accepted,rejected'],
        ]);

        $response = redirect()->route('home')->withCookie(cookie(
            'cookie_consent',
            $validated['choice'],
            60 * 24 * 365,
            '/',
            null,
            $request->isSecure(),
            true,
            false,
            'lax'
        ));

        if ($validated['choice'] === 'rejected') {
            $response->withCookie(cookie()->forget('arogya_visitor_id'));
        }

        return $response;
    }
}
