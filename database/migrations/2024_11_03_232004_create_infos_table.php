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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('TITRE');
            $table->string('objet')->default('OBJET');
            $table->dateTime('will_closed_at')->nullable()->default(null);
            $table->string('content')->nullable()->default('le contenu des infos...');
            $table->json('images')->nullable()->default(null);
            $table->json('targets')->nullable()->default(null);
            $table->json('read_by')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
