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
        Schema::create('epreuve_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('authorized')->nullable()->default(false);
            $table->string('visibity')->nullable()->default('public');
            $table->boolean('hidden')->nullable()->default(false);
            $table->text('description')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('path')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('school_year')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('epreuve_id')->constrained('epreuve_responses')->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epreuve_responses');
    }
};
