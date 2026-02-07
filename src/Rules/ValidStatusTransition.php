<?php

namespace Karnoweb\TicketChat\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Karnoweb\TicketChat\Enums\TicketStatus;
use Karnoweb\TicketChat\Models\Conversation;

class ValidStatusTransition implements ValidationRule
{
    public function __construct(
        protected Conversation $conversation
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $newStatus = TicketStatus::from($value);
        } catch (\ValueError $e) {
            $fail('Invalid status value.');

            return;
        }

        if (! $this->conversation->status->canTransitionTo($newStatus)) {
            $fail("Cannot transition from {$this->conversation->status->value} to {$value}.");
        }
    }
}
