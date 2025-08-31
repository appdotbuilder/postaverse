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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['member', 'moderator', 'admin'])->default('member');
            $table->enum('status', ['pending', 'approved', 'banned'])->default('approved');
            $table->timestamps();
            
            // Ensure unique membership per group
            $table->unique(['group_id', 'user_id']);
            
            // Indexes for performance
            $table->index(['group_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};