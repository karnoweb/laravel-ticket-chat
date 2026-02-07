<?php

namespace Karnoweb\TicketChat\Services;

use Karnoweb\TicketChat\Models\Department;
use Illuminate\Support\Str;

class DepartmentService
{
    public function create(array $data): Department
    {
        return Department::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'email' => $data['email'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'is_default' => $data['is_default'] ?? false,
            'business_hours' => $data['business_hours'] ?? null,
            'auto_assign_strategy' => $data['auto_assign_strategy'] ?? 'manual',
            'order' => $data['order'] ?? 0,
            'meta' => $data['meta'] ?? null,
        ]);
    }

    public function update(Department $department, array $data): bool
    {
        return $department->update($data);
    }

    public function delete(Department $department): bool
    {
        $defaultDepartment = Department::default()->first();

        if ($defaultDepartment && $defaultDepartment->id !== $department->id) {
            $department->conversations()->update([
                'department_id' => $defaultDepartment->id,
            ]);
        }

        return $department->delete();
    }

    public function addAgent(Department $department, int $userId, string $role = 'agent'): void
    {
        $department->users()->syncWithoutDetaching([
            $userId => [
                'role' => $role,
                'is_active' => true,
            ],
        ]);
    }

    public function removeAgent(Department $department, int $userId): void
    {
        $department->users()->detach($userId);
    }

    public function setDefault(Department $department): void
    {
        Department::where('is_default', true)->update(['is_default' => false]);

        $department->update(['is_default' => true]);
    }

    public function getTree(): array
    {
        $departments = Department::active()
            ->orderBy('order')
            ->get();

        return $this->buildTree($departments);
    }

    protected function buildTree($departments, $parentId = null): array
    {
        $tree = [];

        foreach ($departments as $department) {
            if ($department->parent_id === $parentId) {
                $tree[] = [
                    'id' => $department->id,
                    'name' => $department->name,
                    'slug' => $department->slug,
                    'children' => $this->buildTree($departments, $department->id),
                ];
            }
        }

        return $tree;
    }
}
