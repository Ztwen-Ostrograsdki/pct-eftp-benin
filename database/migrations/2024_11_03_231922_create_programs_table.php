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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('objet')->default('OBJET');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('duration')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->json('read_by')->nullable()->default(null);
            $table->text('description')->default(null);
            $table->string('title')->default('TITRE DU PROGRAMME');
            $table->string('place')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
