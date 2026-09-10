<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun Anda Disetujui — IndoTech')
            ->greeting('Halo,')
            ->line('Selamat! Akun Anda di IndoTech telah disetujui oleh tim admin kami.')
            ->line('Anda sekarang dapat login ke akun Anda dan menggunakan semua fitur yang tersedia.')
            ->action('Login Sekarang', url('/login'))
            ->line('Terima kasih telah bergabung dengan IndoTech!');
    }
}
