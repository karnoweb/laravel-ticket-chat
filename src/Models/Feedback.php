<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'rating' => 'integer',
        'meta' => 'array',
    ];

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->table = $prefix.'feedbacks';
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

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopePositive($query)
    {
        $scale = config('ticket-chat.csat.rating_scale', 5);
        $threshold = ceil($scale * 0.6);

        return $query->where('rating', '>=', $threshold);
    }

    public function scopeNegative($query)
    {
        $scale = config('ticket-chat.csat.rating_scale', 5);
        $threshold = ceil($scale * 0.4);

        return $query->where('rating', '<', $threshold);
    }

    public function isPositive(): bool
    {
        $scale = config('ticket-chat.csat.rating_scale', 5);

        return $this->rating >= ceil($scale * 0.6);
    }
}
