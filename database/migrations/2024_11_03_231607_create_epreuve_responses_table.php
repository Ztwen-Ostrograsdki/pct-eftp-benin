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
            $table->uuid('uuid')->unique();
            $table->boolean('authorized')->nullable()->default(false);
            $table->string('extension')->nullable()->default('.pdf');
            $table->string('visibity')->nullable()->default('public');
            $table->boolean('hidden')->nullable()->default(true);
            $table->text('description')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('path')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('file_size')->nullable()->default(null);
            $table->string('school_year')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreignId('epreuve_id')->constrained('epreuves')->cascadeOnDelete();
            $table->unsignedBigInteger('downloaded')->nullable()->default(0);
            $table->json('seen_by')->nullable()->default(null);
            $table->json('downloaded_by')->nullable()->default(null);
            $table->json('likes')->nullable()->default(null);
            $table->string('pages')->nullable()->default(null);
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
