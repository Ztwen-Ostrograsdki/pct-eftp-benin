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
        Schema::create('fedapay_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('mobile_operator')->nullable()->default(null);
            $table->string('customer_id')->nullable()->default(null);
            $table->string('payment_status')->nullable();
            $table->text('description')->nullable()->default(null);
            $table->string('callback_url')->nullable()->default(null);
            $table->string('reference')->nullable()->default(null);
            $table->string('operation')->nullable()->default('payment');
            $table->string('token')->nullable()->default(null);
            $table->decimal('amount', 15, 2)->nullable()->default(0.0);
            $table->decimal('tax', 15, 2)->nullable()->default(0.0);
            $table->string('transaction_id')->nullable()->default(null);
            $table->string('receipt_email')->nullable()->default(null);
            $table->unsignedBigInteger('order_id')->nullable()->default(null);
            $table->string('transaction_key')->nullable()->default(null);
            $table->string('order_identifiant')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fedapay_transactions');
    }
};
