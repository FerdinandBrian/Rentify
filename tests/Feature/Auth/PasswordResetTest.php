<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, SendOtpNotification::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        $otp = Cache::get("otp:password_reset:{$user->email}");
        $this->assertNotNull($otp);

        $verifyResponse = $this->post('/otp/verify', [
            'email' => $user->email,
            'type' => 'password_reset',
            'otp' => $otp,
        ]);

        $verifyResponse->assertRedirect(route('password.reset.form'));

        $response = $this->get('/password/reset-form');
        $response->assertStatus(200);
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        $otp = Cache::get("otp:password_reset:{$user->email}");
        $this->assertNotNull($otp);

        $verifyResponse = $this->post('/otp/verify', [
            'email' => $user->email,
            'type' => 'password_reset',
            'otp' => $otp,
        ]);

        $verifyResponse->assertRedirect(route('password.reset.form'));

        $response = $this->post('/password/reset-otp', [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));
    }
}
