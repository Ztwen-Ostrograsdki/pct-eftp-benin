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
        Schema::create('card_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->unsignedBigInteger('generate_by')->nullable()->default(null);
            $table->date('declared_as_lost_at')->nullable()->default(null);
            $table->date('last_print_date')->nullable()->default(null);
            $table->datetime('expired_at')->nullable()->default(null);
            $table->unsignedBigInteger('total_print')->nullable()->default(0);
            $table->string('card_number')->nullable()->default(0);
            $table->text('code_qr')->nullable()->default(null);
            $table->boolean('closed_because_lost')->nullable()->default(false);
            $table->boolean('print_blocked')->nullable()->default(false);
            $table->boolean('expired')->nullable()->default(false);
            $table->boolean('card_sent_by_mail')->nullable()->default(false);
            $table->string('status')->nullable()->default(null);
            $table->string('card_path')->nullable()->default(null);
            $table->string('key')->nullable()->default(null);
            $table->timestamps();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_members');
    }
};
