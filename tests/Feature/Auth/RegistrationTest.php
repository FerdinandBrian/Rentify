<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        \App\Models\Role::create(['id' => 3, 'name' => 'customer']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('otp.verify', [
            'type' => 'email_verification',
            'email' => 'test@example.com',
        ]));

        $otp = Cache::get('otp:email_verification:test@example.com');
        $this->assertNotNull($otp);

        $verifyResponse = $this->post('/otp/verify', [
            'email' => 'test@example.com',
            'type' => 'email_verification',
            'otp' => $otp,
        ]);

        $this->assertAuthenticated();
        $verifyResponse->assertRedirect(route('dashboard'));
    }
}
