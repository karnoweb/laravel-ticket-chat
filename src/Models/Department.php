<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'business_hours' => 'array',
        'meta' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'departments');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            if (empty($department->slug)) {
                $department->slug = Str::slug($department->name);
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function users(): BelongsToMany
    {
        $userModel = config('ticket-chat.general.user_model');
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany($userModel, $prefix.'department_users')
            ->withPivot(['role', 'is_active', 'current_load', 'max_load'])
            ->withTimestamps();
    }

    public function agents(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'agent');
    }

    public function admins(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function isWithinBusinessHours(): bool
    {
        if (empty($this->business_hours)) {
            return true;
        }

        $now = now();
        $dayOfWeek = strtolower($now->format('l'));

        if (! isset($this->business_hours[$dayOfWeek])) {
            return false;
        }

        $hours = $this->business_hours[$dayOfWeek];

        if ($hours['closed'] ?? false) {
            return false;
        }

        $currentTime = $now->format('H:i');

        return $currentTime >= $hours['start'] && $currentTime <= $hours['end'];
    }

    public function getNextAvailableAgent()
    {
        $strategy = $this->auto_assign_strategy ?? 'manual';

        if ($strategy === 'manual') {
            return null;
        }

        $agents = $this->agents()
            ->wherePivot('is_active', true)
            ->get();

        if ($agents->isEmpty()) {
            return null;
        }

        if ($strategy === 'round_robin') {
            return $agents->first();
        }

        if ($strategy === 'load_balance') {
            return $agents->sortBy('pivot.current_load')->first();
        }

        return null;
    }
}
