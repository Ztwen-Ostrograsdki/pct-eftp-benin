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
        Schema::create('communiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->restrictOnDelete()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->string('objet')->nullable()->default(null);
            $table->boolean('hidden')->nullable()->default(false);
            $table->string('from')->nullable()->default(null);
            $table->string('pdf_path')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->boolean('send_by_mail')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communiques');
    }
};
