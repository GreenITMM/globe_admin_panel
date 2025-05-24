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
        Schema::create('solar_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade');
            $table->foreignId('solar_category_id')->constrained('solar_categories')->onDelete('cascade');
            $table->integer('parent_category_id')->nullable();
            $table->integer('child_category_id')->nullable();
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->integer('price_mmk')->default(0);
            $table->integer('price_us')->default(0);
            $table->integer('qty')->default(0);
            $table->integer('rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solar_products');
    }
};
