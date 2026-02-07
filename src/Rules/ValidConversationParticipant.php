<?php

namespace Karnoweb\TicketChat\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Karnoweb\TicketChat\Models\Conversation;

class ValidConversationParticipant implements ValidationRule
{
    public function __construct(
        protected Conversation $conversation
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isParticipant = $this->conversation
            ->participants()
            ->where('user_id', $value)
            ->whereNull('left_at')
            ->exists();

        if (! $isParticipant) {
            $fail('User is not a participant in this conversation.');
        }
    }
}
