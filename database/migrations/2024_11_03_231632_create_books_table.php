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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('authorized')->nullable()->default(false);
            $table->string('slug')->unique();
            $table->boolean('on_sale')->nullable()->default(true);
            $table->boolean('is_active')->nullable()->default(true);
            $table->decimal('price', 15, 2)->nullable()->default(null);
            $table->string('visibity')->nullable()->default('public');
            $table->boolean('hidden')->nullable()->default(false);
            $table->text('description')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('edited_home')->nullable()->default(null);
            $table->string('last_edited_year')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
            $table->json('filiars_id')->nullable()->default(null);
            $table->json('classes_id')->nullable()->default(null);
            $table->json('likes')->nullable()->default(null);
            $table->unsignedBigInteger('quantity_bought')->nullable()->default(0);
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
