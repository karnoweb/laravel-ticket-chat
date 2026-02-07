<?php

namespace Karnoweb\TicketChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CannedResponse extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        $this->setTable($prefix.'canned_responses');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function createdBy(): BelongsTo
    {
        $userModel = config('ticket-chat.general.user_model');

        return $this->belongsTo($userModel, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('department_id');
    }

    public function scopeForDepartment($query, int $departmentId)
    {
        return $query->where(function ($q) use ($departmentId) {
            $q->whereNull('department_id')
                ->orWhere('department_id', $departmentId);
        });
    }

    public function render(array $variables = []): string
    {
        $body = $this->body;

        foreach ($variables as $key => $value) {
            $body = str_replace("{{$key}}", $value, $body);
        }

        return $body;
    }

    public function getPlaceholders(): array
    {
        preg_match_all('/\{(\w+)\}/', $this->body, $matches);

        return $matches[1] ?? [];
    }
}
