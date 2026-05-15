<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
        }

        if (!OtpCode::canResend($request->email, 'password_reset')) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Tunggu 60 detik sebelum mengirim ulang kode OTP.');
        }

        $code = OtpCode::generate($request->email, 'password_reset');
        $user->notify(new SendOtpNotification($code, 'password_reset'));

        return redirect()->route('otp.verify', [
            'type' => 'password_reset',
            'email' => $user->email,
        ])->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
}
