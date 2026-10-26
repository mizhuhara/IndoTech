<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Email Anda - IndoTech')
            ->greeting('Halo,')
            ->line('Klik tombol di bawah untuk memverifikasi alamat email akun IndoTech Anda.')
            ->action('Verifikasi Email', $url)
            ->line('Tautan verifikasi berlaku selama 60 menit.')
            ->line('Jika Anda tidak membuat akun, abaikan email ini.');
    }
}
