<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdated extends Notification
{
    public function __construct(
        protected Ticket $ticket,
        protected User $updatedBy
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ticket Status Updated')
            ->line("Status tiket {$this->ticket->title} telah diperbarui menjadi {$this->ticket->status}.")
            ->line("Diperbarui oleh: {$this->updatedBy->name}")
            ->action('Lihat Tiket', url(route('student.tickets.show', $this->ticket)))
            ->line('Terima kasih telah menggunakan layanan Helpdesk Kampus.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->ticket->title,
            'status' => $this->ticket->status,
            'updated_by' => $this->updatedBy->name,
            'message' => "Status tiket {$this->ticket->title} sekarang {$this->ticket->status}.",
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}

