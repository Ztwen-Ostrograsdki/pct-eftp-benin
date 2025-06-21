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
        Schema::table('epreuves', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullOnDelete()->nullable()->change();
        });

        Schema::table('support_files', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullOnDelete()->nullable()->change();
        });
        
        Schema::table('epreuve_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullOnDelete()->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('epreuves', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
        
        Schema::table('support_files', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
        
        Schema::table('epreuve_responses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
