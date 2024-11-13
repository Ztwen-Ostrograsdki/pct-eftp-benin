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
        Schema::create('teacher_cursuses', function (Blueprint $table) {
            $table->id();
            $table->date('from')->nullable()->default(null);
            $table->date('to')->nullable()->default(null);
            $table->json('classes')->nullable()->default(null);
            $table->json('schools')->nullable()->default(null);
            $table->string('school_year')->nullable()->default(null);
            $table->string('duration')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_cursuses');
    }
};
