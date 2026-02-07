<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message,
        public int $userId
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        if (! config('ticket-chat.broadcasting.events.message_read', true)) {
            return [];
        }

        return [
            new PrivateChannel('conversation.'.$this->message->conversation_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.read';
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->message->id,
            'user_id' => $this->userId,
            'read_at' => now()->toISOString(),
        ];
    }
}
