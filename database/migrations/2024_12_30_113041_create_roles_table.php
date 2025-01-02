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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('is_active')->nullable()->default(false);
            $table->string('name')->unique();
            $table->string('ability')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->json('tasks')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
