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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('content');
            $table->json('media')->nullable()->comment('Array of media files (images/videos)');
            $table->enum('privacy', ['public', 'friends', 'private'])->default('public');
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'created_at']);
            $table->index('published_at');
            $table->index('privacy');
            $table->index('is_pinned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};