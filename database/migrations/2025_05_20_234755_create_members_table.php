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
        Schema::disableForeignKeyConstraints();
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('authorized')->default(true);
            $table->string('ability')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->json('tasks')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->nullable()->constrained('roles')->cascadeOnDelete()->nullOnDelete()->default(null);
            $table->boolean('card_sent_by_mail')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
