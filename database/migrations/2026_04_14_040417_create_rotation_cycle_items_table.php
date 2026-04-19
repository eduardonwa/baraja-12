<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rotation_cycle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rotation_cycle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hook_id')->constrained()->cascadeOnDelete();
            $table->foreignId('idea_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position');
            $table->boolean('done')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['rotation_cycle_id', 'position']);
            $table->unique(['rotation_cycle_id', 'hook_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rotation_cycle_items');
    }
};
