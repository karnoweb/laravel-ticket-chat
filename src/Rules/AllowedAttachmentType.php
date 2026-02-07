<?php

namespace Karnoweb\TicketChat\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class AllowedAttachmentType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            $fail('Invalid file.');

            return;
        }

        $allowedMimes = config('ticket-chat.attachments.allowed_mimes', []);

        if (empty($allowedMimes)) {
            return;
        }

        $extension = strtolower($value->getClientOriginalExtension());

        if (! in_array($extension, $allowedMimes)) {
            $fail("File type .{$extension} is not allowed. Allowed types: ".implode(', ', $allowedMimes));
        }
    }
}
