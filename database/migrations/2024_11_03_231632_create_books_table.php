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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('authorized')->nullable()->default(false);
            $table->boolean('on_sale')->nullable()->default(true);
            $table->boolean('is_active')->nullable()->default(true);
            $table->decimal('price', 15, 2);
            $table->string('visibity')->nullable()->default('public');
            $table->boolean('hidden')->nullable()->default(false);
            $table->text('description')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('last_edited_year')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->json('filiars_id')->nullable()->default(null);
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
            $table->json('likes')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
