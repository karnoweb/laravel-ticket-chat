<?php

namespace Karnoweb\TicketChat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Karnoweb\TicketChat\Models\Conversation;

class SlaBreachWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Conversation $ticket,
        public float $percentageUsed,
        public int $remainingMinutes
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $hoursRemaining = round($this->remainingMinutes / 60, 1);

        return (new MailMessage)
            ->subject("SLA Warning: {$this->ticket->ticket_number}")
            ->greeting('SLA Breach Warning!')
            ->line("Ticket **{$this->ticket->ticket_number}** is approaching SLA breach.")
            ->line("**Title:** {$this->ticket->title}")
            ->line("**Priority:** {$this->ticket->priority->label()}")
            ->line('**Time Used:** '.round($this->percentageUsed).'%')
            ->line("**Time Remaining:** {$hoursRemaining} hours")
            ->action('Respond Now', url('/'))
            ->line('Please respond immediately to avoid SLA breach.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'sla_warning',
            'conversation_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'percentage_used' => $this->percentageUsed,
            'remaining_minutes' => $this->remainingMinutes,
        ];
    }
}
