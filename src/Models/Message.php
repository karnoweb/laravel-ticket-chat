<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Karnoweb\TicketChat\Enums\MessageType;

class Message extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => MessageType::class,
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
        'mentions' => 'array',
        'meta' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'messages');
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

    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'reply_to_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function readBy(): BelongsToMany
    {
        $userModel = config('ticket-chat.general.user_model');
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany($userModel, $prefix.'message_reads')
            ->withPivot('read_at');
    }

    public function scopeVisible($query)
    {
        return $query->where('type', '!=', MessageType::INTERNAL_NOTE);
    }

    public function scopeInternalNotes($query)
    {
        return $query->where('type', MessageType::INTERNAL_NOTE);
    }

    public function scopeWithMentions($query)
    {
        return $query->whereNotNull('mentions');
    }

    public function isInternalNote(): bool
    {
        return $this->type === MessageType::INTERNAL_NOTE;
    }

    public function isSystem(): bool
    {
        return $this->type === MessageType::SYSTEM;
    }

    public function canBeEdited(): bool
    {
        if (! config('ticket-chat.messages.allow_edit', true)) {
            return false;
        }

        $windowMinutes = config('ticket-chat.messages.edit_window_minutes', 15);

        return $this->created_at->diffInMinutes(now()) <= $windowMinutes;
    }

    public function hasBeenReadBy($userId): bool
    {
        return $this->readBy()->where('user_id', $userId)->exists();
    }

    public function markAsReadBy($userId): void
    {
        if ($this->user_id === $userId) {
            return;
        }

        $this->readBy()->syncWithoutDetaching([
            $userId => ['read_at' => now()],
        ]);
    }
}
