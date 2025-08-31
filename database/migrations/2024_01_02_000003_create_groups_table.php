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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->enum('privacy', ['public', 'private', 'secret'])->default('public');
            $table->integer('members_count')->default(1);
            $table->json('rules')->nullable()->comment('Group rules and guidelines');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('creator_id');
            $table->index('privacy');
            $table->index('is_active');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};