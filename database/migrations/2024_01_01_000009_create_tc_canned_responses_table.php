<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'canned_responses', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained($prefix.'departments')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('title');
            $table->string('shortcut')->nullable()->unique();
            $table->text('body');
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('department_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'canned_responses');
    }
};
