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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->text('bio')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('bio');
            $table->string('cover_image')->nullable()->after('avatar');
            $table->string('location')->nullable()->after('cover_image');
            $table->string('website')->nullable()->after('location');
            $table->date('birth_date')->nullable()->after('website');
            $table->enum('privacy', ['public', 'private'])->default('public')->after('birth_date');
            $table->boolean('is_admin')->default(false)->after('privacy');
            $table->timestamp('last_active_at')->nullable()->after('is_admin');
            
            // Indexes for performance
            $table->index('username');
            $table->index('is_admin');
            $table->index('last_active_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'bio', 'avatar', 'cover_image', 'location', 
                'website', 'birth_date', 'privacy', 'is_admin', 'last_active_at'
            ]);
        });
    }
};