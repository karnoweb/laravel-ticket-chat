<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'feedbacks', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('conversation_id')->constrained($prefix.'conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
            $table->index('rating');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'feedbacks');
    }
};
