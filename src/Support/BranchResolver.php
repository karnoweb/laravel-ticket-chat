<?php

namespace Karnoweb\TicketChat\Support;

class BranchResolver
{
    /**
     * Resolve effective branch ID: when multi_branch is on and default_branch_id is set,
     * use it when $branchId is null so creates/reads automatically use the default branch.
     */
    public static function resolve(?int $branchId): ?int
    {
        if (! config('ticket-chat.features.multi_branch', false)) {
            return $branchId;
        }

        $default = config('ticket-chat.general.default_branch_id');
        if ($default === null || $default === '') {
            return $branchId;
        }

        return $branchId ?? (int) $default;
    }
}
