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
        Schema::create('content_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rotation_cycle_item_id')->constrained()->cascadeOnDelete();
            
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->text('people_tagged_and_dmd')->nullable();
            $table->text('hashtags_used')->nullable();
            
            $table->unsignedInteger('comments_24h')->nullable();
            $table->unsignedInteger('comments_3d')->nullable();
            $table->unsignedInteger('comments_7d')->nullable();
            
            $table->unsignedInteger('follows_24h')->nullable();
            $table->unsignedInteger('follows_3d')->nullable();
            $table->unsignedInteger('follows_7d')->nullable();

            $table->unsignedInteger('likes_24h')->nullable();
            $table->unsignedInteger('likes_3d')->nullable();
            $table->unsignedInteger('likes_7d')->nullable();

            $table->unsignedInteger('profile_visits_24h')->nullable();
            $table->unsignedInteger('profile_visits_3d')->nullable();
            $table->unsignedInteger('profile_visits_7d')->nullable();
            
            $table->unsignedInteger('reposts_24h')->nullable();
            $table->unsignedInteger('reposts_3d')->nullable();
            $table->unsignedInteger('reposts_7d')->nullable();
                        
            $table->unsignedInteger('saves_24h')->nullable();
            $table->unsignedInteger('saves_3d')->nullable();
            $table->unsignedInteger('saves_7d')->nullable();
            
            $table->unsignedInteger('shares_24h')->nullable();
            $table->unsignedInteger('shares_3d')->nullable();
            $table->unsignedInteger('shares_7d')->nullable();

            $table->unsignedInteger('views_24h')->nullable();
            $table->unsignedInteger('views_3d')->nullable();
            $table->unsignedInteger('views_7d')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_metrics');
    }
};
