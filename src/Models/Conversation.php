<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Karnoweb\TicketChat\Enums\ConversationType;
use Karnoweb\TicketChat\Enums\TicketStatus;
use Karnoweb\TicketChat\Enums\TicketPriority;

class Conversation extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => ConversationType::class,
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
        'is_locked' => 'boolean',
        'meta' => 'array',
        'closed_at' => 'datetime',
        'resolved_at' => 'datetime',
        'first_response_at' => 'datetime',
        'last_message_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'conversations');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedAgent(): BelongsTo
    {
        $userModel = config('ticket-chat.general.user_model');

        return $this->belongsTo($userModel, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        $userModel = config('ticket-chat.general.user_model');

        return $this->belongsTo($userModel, 'created_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function participants(): BelongsToMany
    {
        $userModel = config('ticket-chat.general.user_model');
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany($userModel, $prefix.'conversation_participants')
            ->using(ConversationParticipant::class)
            ->withPivot(['role', 'last_read_at', 'joined_at', 'left_at', 'is_muted', 'settings'])
            ->withTimestamps();
    }

    public function tags(): BelongsToMany
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany(Tag::class, $prefix.'conversation_tags');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function scopeTickets($query)
    {
        return $query->where('type', ConversationType::TICKET);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', [TicketStatus::OPEN, TicketStatus::PENDING, TicketStatus::IN_PROGRESS]);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', TicketStatus::CLOSED);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function isTicket(): bool
    {
        return $this->type === ConversationType::TICKET;
    }

    public function isDirect(): bool
    {
        return $this->type === ConversationType::DIRECT;
    }

    public function isGroup(): bool
    {
        return $this->type === ConversationType::GROUP;
    }

    public function isChannel(): bool
    {
        return $this->type === ConversationType::CHANNEL;
    }

    public function isClosed(): bool
    {
        return $this->status === TicketStatus::CLOSED;
    }

    public function isOpen(): bool
    {
        return in_array($this->status, [TicketStatus::OPEN, TicketStatus::PENDING, TicketStatus::IN_PROGRESS]);
    }

    public function isLocked(): bool
    {
        return $this->is_locked;
    }

    public function unreadCountForUser($userId): int
    {
        $participant = $this->participants()->where('user_id', $userId)->first();

        if (! $participant) {
            return 0;
        }

        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->when($participant->pivot->last_read_at, function ($query) use ($participant) {
                $query->where('created_at', '>', $participant->pivot->last_read_at);
            })
            ->count();
    }

    public function generateTicketNumber(): string
    {
        $prefix = config('ticket-chat.tickets.ticket_number_prefix', 'TKT-');
        $length = config('ticket-chat.tickets.ticket_number_length', 8);

        do {
            $number = $prefix.strtoupper(substr(uniqid(), -$length));
        } while (self::where('ticket_number', $number)->exists());

        return $number;
    }
}
