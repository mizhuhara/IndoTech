<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public JobApplication $application,
        public string $previousStatus,
        public ?string $note = null
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $oldLabel = JobApplication::STATUS_LABELS[$this->previousStatus] ?? ucfirst($this->previousStatus);
        $newLabel = $this->application->statusLabel();

        $message = (new MailMessage)
            ->subject('Pembaruan Lamaran — IndoTech')
            ->greeting("Halo {$this->application->full_name},")
            ->line("Ada pembaruan untuk lamaran Anda sebagai {$this->application->positionTitle()} di {$this->application->companyName()}.");

        if ($oldLabel === $newLabel) {
            $message->line("Status lamaran: {$newLabel}");
        } else {
            $message
                ->line("Status sebelumnya: {$oldLabel}")
                ->line("Status sekarang: {$newLabel}");
        }

        if ($this->note !== null) {
            $message->line("Catatan dari admin: {$this->note}");
        }

        return $message
            ->action('Lihat Lamaran', url('/dashboard/applications'))
            ->line('Terima kasih telah menggunakan IndoTech.');
    }
}
