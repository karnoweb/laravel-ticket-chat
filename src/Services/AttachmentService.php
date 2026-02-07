<?php

namespace Karnoweb\TicketChat\Services;

use Karnoweb\TicketChat\Models\Attachment;
use Karnoweb\TicketChat\Models\Message;
use Karnoweb\TicketChat\Exceptions\FileUploadException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    public function upload(Message $message, UploadedFile $file): Attachment
    {
        $this->validateFile($file);

        $disk = config('ticket-chat.attachments.disk', 'public');
        $path = config('ticket-chat.attachments.path', 'ticket-chat/attachments');

        $fileName = $this->generateFileName($file);
        $filePath = $file->storeAs($path.'/'.$message->conversation_id, $fileName, $disk);

        $attachment = Attachment::create([
            'message_id' => $message->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => $disk,
        ]);

        if ($this->isImage($file) && config('ticket-chat.attachments.generate_thumbnails', true)) {
            $this->generateThumbnail($attachment);
        }

        return $attachment;
    }

    public function uploadMultiple(Message $message, array $files): array
    {
        $maxFiles = config('ticket-chat.attachments.max_files_per_message', 5);

        if (count($files) > $maxFiles) {
            throw new FileUploadException("Maximum {$maxFiles} files allowed per message");
        }

        $attachments = [];
        foreach ($files as $file) {
            $attachments[] = $this->upload($message, $file);
        }

        return $attachments;
    }

    public function delete(Attachment $attachment): bool
    {
        Storage::disk($attachment->disk)->delete($attachment->file_path);

        if ($attachment->thumbnail_path) {
            Storage::disk($attachment->disk)->delete($attachment->thumbnail_path);
        }

        return $attachment->delete();
    }

    public function getUrl(Attachment $attachment): string
    {
        return Storage::disk($attachment->disk)->url($attachment->file_path);
    }

    public function getThumbnailUrl(Attachment $attachment): ?string
    {
        if (! $attachment->thumbnail_path) {
            return null;
        }

        return Storage::disk($attachment->disk)->url($attachment->thumbnail_path);
    }

    protected function validateFile(UploadedFile $file): void
    {
        $maxSize = config('ticket-chat.attachments.max_size_mb', 10) * 1024 * 1024;
        $allowedMimes = config('ticket-chat.attachments.allowed_mimes', []);

        if ($file->getSize() > $maxSize) {
            throw new FileUploadException('File size exceeds maximum allowed size');
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (! empty($allowedMimes) && ! in_array($extension, $allowedMimes)) {
            throw new FileUploadException('File type not allowed');
        }
    }

    protected function generateFileName(UploadedFile $file): string
    {
        return Str::uuid().'.'.$file->getClientOriginalExtension();
    }

    protected function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    protected function generateThumbnail(Attachment $attachment): void
    {
        // Placeholder - use Intervention Image or similar for actual thumbnail generation
    }
}
