<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $type = $request->query('type', 'email_verification');
        $email = $request->query('email', '');

        if (!$email && Auth::check()) {
            $email = Auth::user()->email;
        }

        if (!$email) {
            return redirect()->route('login');
        }

        return view('auth.otp-verify', [
            'email' => $email,
            'type' => $type,
        ]);
    }

    /**
     * Verify the OTP code.
     */
    public function verify(VerifyOtpRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Email tidak ditemukan.']);
        }

        $isValid = OtpCode::verify($request->email, $request->otp, $request->type);

        if (!$isValid) {
            return back()
                ->withInput()
                ->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
        }

        return match ($request->type) {
            'email_verification' => $this->handleEmailVerification($user),
            'password_reset' => $this->handlePasswordReset($user, $request),
            'login' => $this->handleLoginVerification($user, $request),
            default => redirect()->route('login'),
        };
    }

    /**
     * Resend OTP code.
     */
    public function resend(ResendOtpRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        if (!OtpCode::canResend($request->email, $request->type)) {
            return back()->with('error', 'Tunggu 60 detik sebelum mengirim ulang kode OTP.');
        }

        $code = OtpCode::generate($request->email, $request->type);
        $user->notify(new SendOtpNotification($code, $request->type));

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    /**
     * Handle email verification after OTP confirmed.
     */
    protected function handleEmailVerification(User $user): RedirectResponse
    {
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Email berhasil diverifikasi!');
    }

    /**
     * Handle password reset after OTP confirmed.
     */
    protected function handlePasswordReset(User $user, Request $request): RedirectResponse
    {
        // Store a temporary token in session so the reset-password form knows the user is verified
        $request->session()->put('otp_verified_email', $user->email);
        $request->session()->put('otp_verified_at', now()->timestamp);

        return redirect()->route('password.reset.form');
    }

    /**
     * Handle login verification after OTP confirmed.
     */
    protected function handleLoginVerification(User $user, Request $request): RedirectResponse
    {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
