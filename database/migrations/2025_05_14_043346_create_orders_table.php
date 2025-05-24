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
            $table->string('order_code')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('address');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->integer('total_item_qty')->default(0);
            $table->integer('sub_total')->default(0);
            $table->integer('shipping_fee')->default(0);
            $table->integer('total')->default(0);
            $table->string('payment_method');
            $table->string('slip')->nullable();
            $table->string('status')->default('pending');
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
