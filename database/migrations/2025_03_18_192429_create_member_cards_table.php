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
        Schema::create('member_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->date('last_print')->nullable()->default(null);
            $table->unsignedBigInteger('total_print')->nullable()->default(0);
            $table->boolean('print_blocked')->nullable()->default(false);
            $table->boolean('requesting')->nullable()->default(false);
            $table->boolean('card_expired')->nullable()->default(false);
            $table->string('status')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_cards');
    }
};
