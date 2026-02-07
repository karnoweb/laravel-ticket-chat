<?php

namespace Karnoweb\TicketChat\Events;

use Karnoweb\TicketChat\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingIndicator implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Conversation $conversation,
        public int $userId,
        public bool $isTyping = true
    ) {}

    public function broadcastOn(): array
    {
        if (! config('ticket-chat.broadcasting.enabled', true)) {
            return [];
        }

        if (! config('ticket-chat.broadcasting.events.typing_indicator', true)) {
            return [];
        }

        return [
            new PrivateChannel('conversation.'.$this->conversation->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }

    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userId,
            'is_typing' => $this->isTyping,
        ];
    }
}
