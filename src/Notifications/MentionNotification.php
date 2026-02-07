<?php

namespace Karnoweb\TicketChat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Karnoweb\TicketChat\Models\Message;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Message $message
    ) {}

    public function via(object $notifiable): array
    {
        return config('ticket-chat.notifications.channels', ['mail', 'database']);
    }

    public function toMail(object $notifiable): MailMessage
    {
        $sender = $this->message->user;

        return (new MailMessage)
            ->subject("You were mentioned by ".($sender->name ?? 'Someone'))
            ->greeting("Hello {$notifiable->name}!")
            ->line(($sender->name ?? 'Someone').' mentioned you in a conversation:')
            ->line('"'.str()->limit($this->message->body, 200).'"')
            ->action('View Message', url('/'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mention',
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user?->name,
        ];
    }
}
