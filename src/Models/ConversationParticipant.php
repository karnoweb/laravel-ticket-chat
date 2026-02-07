<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Karnoweb\TicketChat\Enums\ParticipantRole;

class ConversationParticipant extends Pivot
{
    protected $guarded = [];

    protected $casts = [
        'role' => ParticipantRole::class,
        'is_muted' => 'boolean',
        'settings' => 'array',
        'last_read_at' => 'datetime',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'conversation_participants');
    }

    public function hasLeft(): bool
    {
        return $this->left_at !== null;
    }

    public function canManage(): bool
    {
        return $this->role->canManageConversation();
    }
}
