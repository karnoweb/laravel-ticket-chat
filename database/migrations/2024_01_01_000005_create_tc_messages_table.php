<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'messages', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('conversation_id')->constrained($prefix.'conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('reply_to_id')->nullable()->constrained($prefix.'messages')->nullOnDelete();
            $table->string('type')->default('text');
            $table->text('body')->nullable();
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();
            $table->json('mentions')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('conversation_id');
            $table->index('user_id');
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'messages');
    }
};
