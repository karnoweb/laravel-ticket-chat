<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->json('business_hours')->nullable();
            $table->string('auto_assign_strategy')->default('manual');
            $table->integer('order')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_id');
            $table->index('is_active');
        });

        Schema::table($prefix.'departments', function (Blueprint $table) use ($prefix) {
            $table->foreign('parent_id')->references('id')->on($prefix.'departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::table($prefix.'departments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists($prefix.'departments');
    }
};
