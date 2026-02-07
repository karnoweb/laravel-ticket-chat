<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'message_reads', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('message_id')->constrained($prefix.'messages')->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->timestamp('read_at')->useCurrent();

            $table->unique(['message_id', 'user_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'message_reads');
    }
};
