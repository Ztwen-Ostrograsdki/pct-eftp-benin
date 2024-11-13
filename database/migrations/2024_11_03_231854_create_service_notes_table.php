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
        Schema::create('service_notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable()->default(null);
            $table->dateTime('will_closed_at')->nullable()->default(null);
            $table->json('images')->nullable()->default(null);
            $table->json('targets')->nullable()->default(null);
            $table->json('read_by')->nullable()->default(null);
            $table->string('to')->nullable()->default(null);
            $table->string('from')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_notes');
    }
};
