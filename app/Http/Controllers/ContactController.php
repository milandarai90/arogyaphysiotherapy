<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the public contact page.
     */
    public function index()
    {
        $siteSettings = Setting::all()->keyBy('key');

        return view('pages.contact', compact('siteSettings'));
    }

    /**
     * Store a contact enquiry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]{7,20}$/'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for contacting us. We will get back to you soon.');
    }
}
