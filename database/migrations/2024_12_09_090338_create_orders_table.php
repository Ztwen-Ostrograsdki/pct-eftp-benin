<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'canceled'])->default('new');
            $table->string('currency')->nullable()->default('FCFA');
            $table->decimal('shipping_amount', 15, 2)->nullable();
            $table->string('shipping_method')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->string('identifiant')->unique();
            $table->decimal('discount')->nullable()->default(0);
            $table->decimal('tax', 15, 2)->nullable()->default(0.0);
            $table->boolean('completed')->default(false);
            $table->date('shipping_date')->nullable()->default(null);
            $table->decimal('shipping_price', 15, 2)->nullable()->default(0.0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
