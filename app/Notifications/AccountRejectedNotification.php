<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ?string $reason = null)
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
        $message = (new MailMessage)
            ->subject('Pendaftaran Akun Anda Ditolak — IndoTech')
            ->greeting('Halo,')
            ->line('Kami mengharapkan untuk memberi tahu Anda bahwa pendaftaran akun Anda di IndoTech telah ditolak.')
            ->line('Hal ini biasanya disebabkan oleh dokumen yang tidak lengkap atau tidak valid.');

        if ($this->reason) {
            $message->line("Alasan: {$this->reason}");
        }

        $message->line('Silakan hubungi tim dukungan kami jika Anda memiliki pertanyaan.');

        return $message;
    }
}
