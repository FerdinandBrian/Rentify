<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'role_id' => 3, // 3 = Customer
            'name' => $validated['name'],
            'email' => $validated['email'],
            'call_number' => $validated['call_number'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        // Generate and send OTP for email verification via cache
        $code = OtpCode::generate($user->email, 'email_verification');
        $user->notify(new SendOtpNotification($code, 'email_verification'));

        return redirect()->route('otp.verify', [
            'type' => 'email_verification',
            'email' => $user->email,
        ])->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
}
