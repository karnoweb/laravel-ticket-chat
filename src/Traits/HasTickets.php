<?php

namespace Karnoweb\TicketChat\Traits;

use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\ConversationType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTickets
{
    public function tickets(): BelongsToMany
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany(Conversation::class, $prefix.'conversation_participants')
            ->where($prefix.'conversations.type', ConversationType::TICKET)
            ->withPivot(['role', 'last_read_at', 'joined_at', 'is_muted'])
            ->withTimestamps();
    }

    public function createdTickets(): HasMany
    {
        return $this->hasMany(Conversation::class, 'created_by')
            ->where('type', ConversationType::TICKET);
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Conversation::class, 'assigned_to')
            ->where('type', ConversationType::TICKET);
    }

    public function openTickets(): BelongsToMany
    {
        return $this->tickets()->whereIn('status', ['open', 'pending', 'in_progress']);
    }

    public function closedTickets(): BelongsToMany
    {
        return $this->tickets()->where('status', 'closed');
    }

    public function ticketUnreadCount(): int
    {
        return app('ticket')->unreadCount($this->id);
    }
}
