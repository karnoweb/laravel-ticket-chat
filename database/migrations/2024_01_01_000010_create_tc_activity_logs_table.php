<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'activity_logs', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('conversation_id')->constrained($prefix.'conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action');
            $table->json('meta')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['conversation_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'activity_logs');
    }
};
