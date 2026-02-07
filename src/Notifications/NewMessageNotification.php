<?php

namespace Karnoweb\TicketChat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Karnoweb\TicketChat\Models\Message;

class NewMessageNotification extends Notification implements ShouldQueue
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
        $conversation = $this->message->conversation;
        $sender = $this->message->user;

        return (new MailMessage)
            ->subject($this->getSubject())
            ->greeting("Hello {$notifiable->name}!")
            ->line(($sender->name ?? 'Someone').' sent a message:')
            ->line('"'.str()->limit($this->message->body, 200).'"')
            ->action('View Conversation', url('/'))
            ->line('Thank you for using our support system!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_message',
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->user_id,
            'sender_name' => $this->message->user?->name,
            'body_preview' => str()->limit($this->message->body, 100),
            'ticket_number' => $this->message->conversation->ticket_number,
        ];
    }

    protected function getSubject(): string
    {
        $conversation = $this->message->conversation;

        if ($conversation->isTicket()) {
            return "[{$conversation->ticket_number}] New Reply: {$conversation->title}";
        }

        return 'New Message';
    }
}
