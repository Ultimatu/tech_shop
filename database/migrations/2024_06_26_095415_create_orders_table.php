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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->double('shipping_fee')->default(0);
            $table->string('order_number')->unique();
            $table->double('total');
            $table->double('total_without_fee');
            $table->string('status')->default('pending');
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->string('shipping_method');
            $table->string('shipping_status')->default('pending');
            $table->foreignId('shipping_address_id')->constrained('shipping_addresses')->cascadeOnDelete()->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropForeign(['user_id']);
        Schema::dropForeign(['shipping_address_id']);
        Schema::dropIfExists('orders');
    }
};
