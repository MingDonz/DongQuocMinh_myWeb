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
            $table->foreignId('customer_id')->constrained();
            $table->string('order_code')->unique(); // mã đơn hàng
            $table->decimal('total_amount', 10, 0); // tổng tiền
            $table->string('status')->default('pending'); // trạng thái đơn hàng
            $table->string('payment_method')->nullable(); // hình thức thanh toán
            $table->string('payment_status')->default('unpaid'); // trạng thái thanh toán
            $table->string('note', 400)->nullable();
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
