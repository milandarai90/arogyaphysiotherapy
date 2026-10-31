<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([

            // Clinic branding
            'clinic_name' => ['required', 'string', 'max:255'],
            'clinic_short_name' => ['nullable', 'string', 'max:100'],
            'clinic_tagline' => ['nullable', 'string', 'max:150'],

            // Contact information
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'emergency_phone' => ['nullable', 'string', 'max:30'],
            'emergency_label' => ['nullable', 'string', 'max:100'],
            'emergency_instructions' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'opening_hours' => ['nullable', 'string', 'max:500'],

            // Google Maps
            'google_maps_embed_url' => [
                'nullable',
                'url',
                'max:2000',
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        return;
                    }

                    $host = parse_url($value, PHP_URL_HOST);
                    $path = parse_url($value, PHP_URL_PATH);

                    $validGoogleMapsUrl =
                        in_array($host, [
                            'www.google.com',
                            'google.com',
                            'maps.google.com',
                        ], true)
                        &&
                        (
                            (
                                in_array($host, [
                                    'www.google.com',
                                    'google.com',
                                ], true)
                                && str_starts_with($path ?? '', '/maps/embed')
                            )
                            ||
                            (
                                $host === 'maps.google.com'
                                && str_starts_with($path ?? '', '/maps')
                            )
                        );

                    if (!$validGoogleMapsUrl) {
                        $fail('Please enter a valid Google Maps Embed URL.');
                    }
                },
            ],

            // Appointment slot settings
            'appointment_slot_interval' => [
                'required',
                'in:10,15,20,30,45,60,custom',
            ],
            'appointment_slot_custom' => [
                'nullable',
                'required_if:appointment_slot_interval,custom',
                'integer',
                'min:5',
                'max:180',
            ],

            // Social media
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'threads' => ['nullable', 'url', 'max:255'],
            'viber' => ['nullable', 'string', 'max:100'],

            // SEO
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],

            // Homepage hero
            'homepage_heading' => ['nullable', 'string', 'max:255'],
            'homepage_intro' => ['nullable', 'string', 'max:2000'],

            // Homepage about section
            'about_heading' => ['nullable', 'string', 'max:255'],
            'about_paragraph_1' => ['nullable', 'string', 'max:2000'],
            'about_paragraph_2' => ['nullable', 'string', 'max:2000'],

            // Full About page
            'about_page_title' => ['nullable', 'string', 'max:255'],
            'about_page_intro' => ['nullable', 'string', 'max:3000'],
            'about_story_heading' => ['nullable', 'string', 'max:255'],
            'about_story' => ['nullable', 'string', 'max:5000'],
            'about_mission' => ['nullable', 'string', 'max:2000'],
            'about_vision' => ['nullable', 'string', 'max:2000'],
            'about_values' => ['nullable', 'string', 'max:3000'],

            // Why choose us
            'why_heading' => ['nullable', 'string', 'max:255'],
            'why_intro' => ['nullable', 'string', 'max:2000'],

            'why_item_1_title' => ['nullable', 'string', 'max:255'],
            'why_item_1_description' => ['nullable', 'string', 'max:1000'],

            'why_item_2_title' => ['nullable', 'string', 'max:255'],
            'why_item_2_description' => ['nullable', 'string', 'max:1000'],

            'why_item_3_title' => ['nullable', 'string', 'max:255'],
            'why_item_3_description' => ['nullable', 'string', 'max:1000'],

            // Homepage section headings
            'services_heading' => ['nullable', 'string', 'max:255'],
            'gallery_heading' => ['nullable', 'string', 'max:255'],
            'blog_heading' => ['nullable', 'string', 'max:255'],

            // Services page
            'services_page_title' => ['nullable', 'string', 'max:255'],
            'services_page_intro' => ['nullable', 'string', 'max:3000'],

            // Contact page
            'contact_page_title' => ['nullable', 'string', 'max:255'],
            'contact_page_intro' => ['nullable', 'string', 'max:3000'],
            'contact_form_heading' => ['nullable', 'string', 'max:255'],

            // Appointment CTA
            'appointment_cta_heading' => ['nullable', 'string', 'max:255'],
            'appointment_cta_description' => ['nullable', 'string', 'max:1000'],
            'appointment_cta_button' => ['nullable', 'string', 'max:100'],

            // Footer
            'footer_text' => ['nullable', 'string', 'max:1000'],

            // Images
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'about_page_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'why_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $imageGroups = [
            'logo' => 'general',
            'favicon' => 'general',
            'hero_image' => 'homepage',
            'about_image' => 'about',
            'about_page_image' => 'about',
            'why_image' => 'why_choose_us',
        ];

        // Resolve the actual appointment interval.
        $interval = $validated['appointment_slot_interval'] === 'custom'
            ? (int) $validated['appointment_slot_custom']
            : (int) $validated['appointment_slot_interval'];

        Setting::updateOrCreate(
            ['key' => 'appointment_slot_interval'],
            [
                'value' => $interval,
                'group' => 'appointments',
            ]
        );

        // Save normal text fields.
        foreach ($validated as $key => $value) {
            if (
                array_key_exists($key, $imageGroups) ||
                in_array($key, [
                    'appointment_slot_interval',
                    'appointment_slot_custom',
                ], true)
            ) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $this->settingGroup($key),
                ]
            );
        }

        // Save uploaded images.
        foreach ($imageGroups as $field => $group) {
            if (!$request->hasFile($field)) {
                continue;
            }

            $oldImage = Setting::where('key', $field)->value('value');

            $newPath = $request->file($field)->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => $field],
                [
                    'value' => $newPath,
                    'group' => $group,
                ]
            );

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Website settings updated successfully.');
    }

    private function settingGroup(string $key): string
    {
        return match (true) {

            in_array($key, [
                'phone',
                'whatsapp',
                'emergency_phone',
                'emergency_label',
                'emergency_instructions',
                'email',
                'address',
                'opening_hours',
                'google_maps_embed_url',
                'contact_page_title',
                'contact_page_intro',
                'contact_form_heading',
            ], true) => 'contact',

            in_array($key, [
                'facebook', 'instagram', 'tiktok', 'youtube',
                'linkedin', 'twitter', 'threads', 'viber',
            ], true) => 'social',

            in_array($key, [
                'seo_title', 'seo_description',
            ], true) => 'seo',

            in_array($key, [
                'homepage_heading', 'homepage_intro', 'hero_image',
                'services_heading', 'gallery_heading', 'blog_heading',
                'appointment_cta_heading', 'appointment_cta_description',
                'appointment_cta_button',
            ], true) => 'homepage',

            in_array($key, [
                'about_heading', 'about_paragraph_1', 'about_paragraph_2',
                'about_image', 'about_page_title', 'about_page_intro',
                'about_story_heading', 'about_story', 'about_mission',
                'about_vision', 'about_values', 'about_page_image',
            ], true) => 'about',

            in_array($key, [
                'services_page_title', 'services_page_intro',
            ], true) => 'services',

            str_starts_with($key, 'why_') => 'why_choose_us',

            $key === 'footer_text' => 'footer',

            in_array($key, [
                'clinic_name',
                'clinic_short_name',
                'clinic_tagline',
                'logo',
                'favicon',
            ], true) => 'general',

            default => 'general',
        };
    }
}
