<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        if (! config('ticket-chat.broadcasting.events.message_sent', true)) {
            return [];
        }

        return [
            new PrivateChannel('conversation.'.$this->message->conversation_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'conversation_id' => $this->message->conversation_id,
                'user_id' => $this->message->user_id,
                'body' => $this->message->body,
                'type' => $this->message->type->value,
                'reply_to_id' => $this->message->reply_to_id,
                'mentions' => $this->message->mentions,
                'created_at' => $this->message->created_at->toISOString(),
                'user' => $this->message->user ? [
                    'id' => $this->message->user->id,
                    'name' => $this->message->user->name,
                ] : null,
                'attachments' => $this->message->attachments->map(fn ($a) => [
                    'id' => $a->id,
                    'file_name' => $a->file_name,
                    'mime_type' => $a->mime_type,
                    'size' => $a->size,
                ])->toArray(),
            ],
        ];
    }
}
