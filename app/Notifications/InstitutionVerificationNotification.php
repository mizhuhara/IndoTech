<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstitutionVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
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
        $roleLabel = match ($this->user->role) {
            'school' => 'Sekolah Vokasi',
            'university' => 'Universitas',
            'company' => 'Perusahaan',
            default => 'Institusi',
        };

        return (new MailMessage)
            ->subject('Verifikasi Akun Institusi Baru — IndoTech')
            ->greeting('Halo Super Admin,')
            ->line('Ada pendaftaran akun institusi baru yang perlu diverifikasi:')
            ->line("Nama: {$this->user->name}")
            ->line("Email: {$this->user->email}")
            ->line("Jenis: {$roleLabel}")
            ->action('Verifikasi Sekarang', url('/admin/verification'))
            ->line('Silakan login ke panel admin untuk meninjau dan menyetujui akun ini.');
    }
}
