<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class OtpPasswordResetController extends Controller
{
    /**
     * Show the reset password form (only accessible after OTP verification).
     */
    public function showResetForm(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('otp_verified_email');
        $verifiedAt = $request->session()->get('otp_verified_at');

        // Check if OTP was verified and within 15 minutes
        if (!$email || !$verifiedAt || (now()->timestamp - $verifiedAt) > 900) {
            $request->session()->forget(['otp_verified_email', 'otp_verified_at']);
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi verifikasi OTP telah berakhir. Silakan coba lagi.']);
        }

        return view('auth.otp-reset-password', ['email' => $email]);
    }

    /**
     * Handle the password reset.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $email = $request->session()->get('otp_verified_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi verifikasi OTP tidak valid.']);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear OTP session data
        $request->session()->forget(['otp_verified_email', 'otp_verified_at']);

        return redirect()->route('login')
            ->with('status', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
