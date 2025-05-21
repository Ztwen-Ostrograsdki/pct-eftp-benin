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
        Schema::create('lycees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('rank')->nullable()->default('non renseigné');
            $table->boolean('is_public')->nullable()->default(true);
            $table->string('provisor')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('censeur')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->json('promotions_id')->nullable()->default(null);
            $table->json('filiars_id')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lycees');
    }
};
