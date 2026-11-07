<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityControlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_web_responses_include_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_website_analytics_requires_explicit_cookie_consent(): void
    {
        $this->get('/')->assertOk();
        $this->assertDatabaseCount('website_visits', 0);

        $this->withCookie('cookie_consent', 'accepted')
            ->get('/')
            ->assertOk();

        $this->assertDatabaseCount('website_visits', 1);
    }

    public function test_cors_does_not_allow_an_untrusted_origin(): void
    {
        $this->withHeader('Origin', 'https://untrusted.example')
            ->options('/')
            ->assertHeaderMissing('Access-Control-Allow-Origin');
    }

    public function test_public_legal_pages_have_page_specific_titles(): void
    {
        $pages = [
            '/privacy-policy' => 'Privacy Policy | Aarogya Physiotherapy Center',
            '/terms-and-conditions' => 'Terms and Conditions | Aarogya Physiotherapy Center',
            '/cookie-policy' => 'Cookie Policy | Aarogya Physiotherapy Center',
        ];

        foreach ($pages as $path => $title) {
            $this->get($path)
                ->assertOk()
                ->assertSee("<title>{$title}</title>", false);
        }
    }

    public function test_admin_login_is_rate_limited_by_email_and_ip(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/admin/login', [
                'email' => 'unknown@example.com',
                'password' => 'incorrect-password',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/admin/login', [
            'email' => 'unknown@example.com',
            'password' => 'incorrect-password',
        ])->assertTooManyRequests();
    }

    public function test_appointment_status_lookups_are_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $this->post('/appointment-status', [])->assertSessionHasErrors();
        }

        $this->post('/appointment-status', [])->assertTooManyRequests();
    }
}
