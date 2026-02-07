<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');

        Schema::create($prefix.'department_users', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->foreignId('department_id')->constrained($prefix.'departments')->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->string('role')->default('agent');
            $table->boolean('is_active')->default(true);
            $table->integer('current_load')->default(0);
            $table->integer('max_load')->default(10);
            $table->timestamps();

            $table->unique(['department_id', 'user_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        $prefix = config('ticket-chat.general.table_prefix', 'tc_');
        Schema::dropIfExists($prefix.'department_users');
    }
};
