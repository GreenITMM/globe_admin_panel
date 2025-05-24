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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('product_type');
            $table->boolean('is_attribute')->default(0);
            $table->integer('product_id')->nullable();
            $table->integer('product_variation_id')->nullable();
            $table->integer('xp_pen_product_id')->nullable();
            $table->integer('solar_product_id')->nullable();
            $table->integer('solar_product_variation_id')->nullable();
            $table->integer('adreamer_product_id')->nullable();
            $table->integer('adreamer_product_variation_id')->nullable();
            $table->integer('qty');
            $table->integer('price_mmk')->default(0);
            $table->integer('price_us')->default(0);
            $table->integer('rate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
