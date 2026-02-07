<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'meta' => 'array',
    ];

    public const UPDATED_AT = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'activity_logs');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user(): BelongsTo
    {
        $userModel = config('ticket-chat.general.user_model');

        return $this->belongsTo($userModel);
    }

    public function scopeForConversation($query, int $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function getDescriptionAttribute(): string
    {
        return match ($this->action) {
            'created' => 'Ticket created',
            'closed' => 'Ticket closed',
            'reopened' => 'Ticket reopened',
            'assigned' => 'Ticket assigned to '.($this->meta['agent_name'] ?? 'agent'),
            'transferred' => 'Ticket transferred to another department',
            'status_changed' => 'Status changed to '.($this->meta['new_status'] ?? 'unknown'),
            'priority_changed' => 'Priority changed to '.($this->meta['new_priority'] ?? 'unknown'),
            'sla_breached' => 'SLA breached',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }
}
