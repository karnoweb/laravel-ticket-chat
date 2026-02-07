<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationAssigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Conversation $conversation,
        public int $agentId
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        return [
            new PrivateChannel('conversation.'.$this->conversation->id),
            new PrivateChannel('user.'.$this->agentId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'conversation.assigned';
    }

    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversation->id,
            'ticket_number' => $this->conversation->ticket_number,
            'assigned_to' => $this->agentId,
            'assigned_at' => now()->toISOString(),
        ];
    }
}
