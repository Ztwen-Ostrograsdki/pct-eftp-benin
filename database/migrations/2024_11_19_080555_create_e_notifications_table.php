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
        Schema::create('e_notifications', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable()->default(null);
            $table->string('object')->nullable()->default('Objet');
            $table->string('title')->nullable()->default('Titre');
            $table->json('images')->nullable()->default(null);
            $table->json('receivers')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->boolean('hide')->nullable()->default(false);
            $table->json('hide_for')->nullable()->default(null);
            $table->json('seen_by')->nullable()->default(null);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_notifications');
    }
};
