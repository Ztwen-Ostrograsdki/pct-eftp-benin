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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('payment_date')->nullable()->default(null);
            $table->string('month')->nullable()->default(null);
            $table->string('year')->nullable()->default(null);
            $table->boolean('validated')->nullable()->default(true);
            $table->string('status')->nullable()->default(null);
            $table->decimal('amount', 15, 2)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
