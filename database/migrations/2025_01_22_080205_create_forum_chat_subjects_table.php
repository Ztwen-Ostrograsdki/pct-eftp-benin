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
        Schema::create('forum_chat_subjects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('closed')->nullable()->default(false);
            $table->boolean('authorized')->nullable()->default(false);
            $table->boolean('active')->nullable()->default(true);
            $table->json('likes')->nullable()->default(null);
            $table->text('subject')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamp('closed_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_chat_subjects');
    }
};
