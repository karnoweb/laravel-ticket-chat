<?php

namespace Karnoweb\TicketChat\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Karnoweb\TicketChat\Models\Conversation;
use Karnoweb\TicketChat\Enums\ConversationType;

class MaxOpenTickets implements ValidationRule
{
    public function __construct(
        protected int $userId
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $maxOpen = config('ticket-chat.tickets.max_open_per_user', 10);

        $openCount = Conversation::query()
            ->where('type', ConversationType::TICKET)
            ->where('created_by', $this->userId)
            ->open()
            ->count();

        if ($openCount >= $maxOpen) {
            $fail("You have reached the maximum number of open tickets ({$maxOpen}).");
        }
    }
}
