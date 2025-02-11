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
        Schema::create('law_articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('law_chapter_id')->constrained('law_chapters')->cascadeOnDelete();
            $table->foreignId('law_id')->constrained('laws')->cascadeOnDelete();
            $table->text('content')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('law_articles');
    }
};
