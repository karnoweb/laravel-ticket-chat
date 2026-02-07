<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'conversations', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->string('type');
            $table->string('ticket_number')->nullable()->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('open');
            $table->string('priority')->default('medium');
            $table->foreignId('department_id')->nullable()->constrained($prefix.'departments')->nullOnDelete();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'status']);
            $table->index('department_id');
            $table->index('branch_id');
            $table->index(['branch_id', 'type', 'status']);
            $table->index('assigned_to');
            $table->index('created_by');
            $table->index('last_message_at');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'conversations');
    }
};
