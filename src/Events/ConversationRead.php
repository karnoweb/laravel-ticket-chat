<?php

namespace Karnoweb\TicketChat\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Karnoweb\TicketChat\Models\Conversation;

/**
 * Aggregated "user read the whole conversation" event (replaces N per-message events).
 */
class ConversationRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @param  array<int, int>  $messageIds
     */
    public function __construct(
        public Conversation $conversation,
        public int $userId,
        public array $messageIds = []
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
            new PrivateChannel('conversation.'.$this->conversation->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'conversation.read';
    }

    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userId,
            'message_ids' => $this->messageIds,
            'read_at' => now()->toISOString(),
        ];
    }
}
