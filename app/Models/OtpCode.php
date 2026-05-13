<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

class OtpCode
{
    /**
     * Cache key prefix for OTP codes.
     */
    protected static function cacheKey(string $email, string $type): string
    {
        return "otp:{$type}:{$email}";
    }

    /**
     * Cache key for rate limiting.
     */
    protected static function rateLimitKey(string $email, string $type): string
    {
        return "otp_ratelimit:{$type}:{$email}";
    }

    /**
     * Generate a new OTP code and store in cache.
     * Returns the generated code string.
     */
    public static function generate(string $email, string $type = 'email_verification'): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in cache for 10 minutes
        Cache::put(static::cacheKey($email, $type), $code, now()->addMinutes(10));

        // Set rate limit for 60 seconds
        Cache::put(static::rateLimitKey($email, $type), true, now()->addSeconds(60));

        return $code;
    }

    /**
     * Verify an OTP code from cache.
     */
    public static function verify(string $email, string $code, string $type = 'email_verification'): bool
    {
        $key = static::cacheKey($email, $type);
        $storedCode = Cache::get($key);

        if ($storedCode && $storedCode === $code) {
            // Remove OTP after successful verification
            Cache::forget($key);
            return true;
        }

        return false;
    }

    /**
     * Check if user can request a new OTP (rate limiting: 1 per 60 seconds).
     */
    public static function canResend(string $email, string $type = 'email_verification'): bool
    {
        return !Cache::has(static::rateLimitKey($email, $type));
    }

    /**
     * Get remaining cooldown seconds before resend is allowed.
     */
    public static function resendCooldown(string $email, string $type = 'email_verification'): int
    {
        $key = static::rateLimitKey($email, $type);

        if (!Cache::has($key)) {
            return 0;
        }

        // For database cache driver, we can't easily get TTL, so return a safe default
        return 60;
    }
}
