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
        Schema::create('epreuve_responses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('authorized')->nullable()->default(false);
            $table->string('visibity')->nullable()->default('public');
            $table->boolean('hidden')->nullable()->default(true);
            $table->text('description')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('path')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('file_size')->nullable()->default(null);
            $table->string('school_year')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('epreuve_id')->constrained('epreuve_responses')->cascadeOnDelete();
            $table->unsignedBigInteger('downloaded')->nullable()->default(0);
            $table->json('seen_by')->nullable()->default(null);
            $table->json('downloaded_by')->nullable()->default(null);
            $table->json('likes')->nullable()->default(null);
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
