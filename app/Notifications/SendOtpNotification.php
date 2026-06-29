<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification
{

    public function __construct(
        protected string $code,
        protected string $type = 'email_verification'
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = match ($this->type) {
            'email_verification' => 'Verifikasi Email - Rentify',
            'password_reset' => 'Reset Password - Rentify',
            'login' => 'Kode Login - Rentify',
            default => 'Kode OTP - Rentify',
        };

        $greeting = match ($this->type) {
            'email_verification' => 'Selamat datang di Rentify! 🚗',
            'password_reset' => 'Reset Password Anda',
            'login' => 'Verifikasi Login Anda',
            default => 'Kode OTP Anda',
        };

        $message = match ($this->type) {
            'email_verification' => 'Gunakan kode di bawah ini untuk memverifikasi email Anda:',
            'password_reset' => 'Gunakan kode di bawah ini untuk mereset password Anda:',
            'login' => 'Gunakan kode di bawah ini untuk menyelesaikan login:',
            default => 'Kode OTP Anda adalah:',
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($message)
            ->line('**' . $this->code . '**')
            ->line('Kode ini berlaku selama 10 menit.')
            ->line('Jika Anda tidak meminta kode ini, abaikan email ini.')
            ->salutation('Salam, Tim Rentify');
    }
}
