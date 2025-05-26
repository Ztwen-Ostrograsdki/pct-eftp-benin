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
        Schema::create('job_report_after_processeds', function (Blueprint $table) {
            $table->id();
            $table->uuid('job_id')->nullable()->index();
            $table->uuid('batch_id')->nullable()->default(null)->index();
            $table->string('job_class')->nullable()->default(null);
            $table->json('payload')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->text('report')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_report_after_processeds');
    }
};
