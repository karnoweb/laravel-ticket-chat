<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'attachments', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('message_id')->constrained($prefix.'messages')->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('disk')->default('public');
            $table->string('thumbnail_path')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('message_id');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'attachments');
    }
};
