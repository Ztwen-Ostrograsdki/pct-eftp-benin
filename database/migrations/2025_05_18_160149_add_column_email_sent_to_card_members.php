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
        Schema::table('card_members', function (Blueprint $table) {
            $table->boolean('card_sent_by_mail')->nullable()->default(false);
            $table->string('card_path')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_members', function (Blueprint $table) {
            //
        });
    }
};
