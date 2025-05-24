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
        Schema::create('adreamer_product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adreamer_product_id')->constrained('adreamer_products')->onDelete('cascade');
            $table->integer('price_mmk')->default(0);
            $table->integer('price_us')->default(0);
            $table->integer('qty')->default(0);
            $table->string('sku')->nullable();
            $table->text('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adreamer_product_variations');
    }
};
