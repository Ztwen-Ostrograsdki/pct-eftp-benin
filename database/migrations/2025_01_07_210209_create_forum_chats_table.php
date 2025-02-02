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
        Schema::create('forum_chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('message')->nullable()->default(null);
            $table->string('file')->nullable()->default(null);
            $table->string('file_path')->nullable()->default(null);
            $table->string('file_size')->nullable()->default(null);
            $table->string('file_extension')->nullable()->default(null);
            $table->string('file_pages')->nullable()->default(null);
            $table->string('reply_to_message_id')->nullable()->default(null);
            $table->json('likes')->nullable()->default(null);
            $table->json('seen_by')->nullable()->default(null);
            $table->json('delete_by')->nullable()->default(null);
            $table->boolean('authorized')->nullable()->default(true);
            $table->boolean('reported')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_chats');
    }
};
