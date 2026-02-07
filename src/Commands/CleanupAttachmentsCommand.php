<?php

namespace Karnoweb\TicketChat\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Karnoweb\TicketChat\Models\Attachment;

class CleanupAttachmentsCommand extends Command
{
    protected $signature = 'ticket-chat:cleanup-attachments
                            {--orphaned : Remove orphaned files not in database}
                            {--older-than= : Remove attachments older than X days}
                            {--dry-run : Show what would be deleted}';

    protected $description = 'Clean up old or orphaned attachments';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $olderThan = $this->option('older-than');
        $orphaned = $this->option('orphaned');

        if ($olderThan) {
            $this->cleanupOldAttachments((int) $olderThan, $dryRun);
        }

        if ($orphaned) {
            $this->cleanupOrphanedFiles($dryRun);
        }

        if (! $olderThan && ! $orphaned) {
            $this->warn('Please specify --older-than=<days> or --orphaned');
        }

        return self::SUCCESS;
    }

    protected function cleanupOldAttachments(int $days, bool $dryRun): void
    {
        $cutoffDate = now()->subDays($days);

        $attachments = Attachment::query()
            ->where('created_at', '<', $cutoffDate)
            ->whereHas('message', function ($query) {
                $query->whereHas('conversation', function ($q) {
                    $q->whereNotNull('deleted_at');
                });
            })
            ->get();

        $this->info("Found {$attachments->count()} attachments to delete.");

        if ($dryRun) {
            $this->warn('Dry run - no files were deleted.');

            return;
        }

        $deleted = 0;
        foreach ($attachments as $attachment) {
            try {
                Storage::disk($attachment->disk)->delete($attachment->file_path);
                if ($attachment->thumbnail_path) {
                    Storage::disk($attachment->disk)->delete($attachment->thumbnail_path);
                }
                $attachment->delete();
                $deleted++;
            } catch (\Exception $e) {
                $this->error("Failed to delete attachment {$attachment->id}: {$e->getMessage()}");
            }
        }

        $this->info("Deleted {$deleted} attachments.");
    }

    protected function cleanupOrphanedFiles(bool $dryRun): void
    {
        $disk = config('ticket-chat.attachments.disk', 'public');
        $path = config('ticket-chat.attachments.path', 'ticket-chat/attachments');

        $files = Storage::disk($disk)->allFiles($path);
        $dbPaths = Attachment::pluck('file_path')->toArray();
        $dbThumbnails = Attachment::whereNotNull('thumbnail_path')->pluck('thumbnail_path')->toArray();

        $allDbPaths = array_merge($dbPaths, $dbThumbnails);

        $orphaned = array_diff($files, $allDbPaths);

        $this->info('Found '.count($orphaned).' orphaned files.');

        if ($dryRun) {
            foreach ($orphaned as $file) {
                $this->line("  - {$file}");
            }
            $this->warn('Dry run - no files were deleted.');

            return;
        }

        foreach ($orphaned as $file) {
            Storage::disk($disk)->delete($file);
        }

        $this->info('Deleted '.count($orphaned).' orphaned files.');
    }
}
