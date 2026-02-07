<?php

namespace Karnoweb\TicketChat\Traits;

use Karnoweb\TicketChat\Models\Department;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait CanBeDepartmentAgent
{
    public function departments(): BelongsToMany
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        return $this->belongsToMany(Department::class, $prefix.'department_users')
            ->withPivot(['role', 'is_active', 'current_load', 'max_load'])
            ->withTimestamps();
    }

    public function activeDepartments(): BelongsToMany
    {
        return $this->departments()
            ->wherePivot('is_active', true)
            ->where('is_active', true);
    }

    public function isDepartmentAdmin(Department $department): bool
    {
        return $this->departments()
            ->where('department_id', $department->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    public function isDepartmentAgent(Department $department): bool
    {
        return $this->departments()
            ->where('department_id', $department->id)
            ->exists();
    }
}
