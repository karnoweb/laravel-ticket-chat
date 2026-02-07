<?php

namespace Karnoweb\TicketChat\Traits;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Enums\ConversationType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasConversations
{
    public function conversations(): BelongsToMany
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany(Conversation::class, $prefix.'conversation_participants')
            ->withPivot(['role', 'last_read_at', 'joined_at', 'left_at', 'is_muted', 'settings'])
            ->withTimestamps();
    }

    public function directConversations(): BelongsToMany
    {
        return $this->conversations()->where('type', ConversationType::DIRECT);
    }

    public function groupConversations(): BelongsToMany
    {
        return $this->conversations()->where('type', ConversationType::GROUP);
    }

    public function channelSubscriptions(): BelongsToMany
    {
        return $this->conversations()->where('type', ConversationType::CHANNEL);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function totalUnreadCount(): int
    {
        return app('chat')->unreadCount($this->id);
    }

    public function unreadCountFor(Conversation $conversation): int
    {
        return app('chat')->unreadCount($this->id, $conversation);
    }
}
