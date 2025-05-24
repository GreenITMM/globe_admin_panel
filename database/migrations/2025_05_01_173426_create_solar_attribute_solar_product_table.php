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
        Schema::create('solar_attribute_solar_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solar_attribute_id')->constrained('solar_attributes')->onDelete('cascade');
            $table->foreignId('solar_product_id')->constrained('solar_products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solar_attribute_solar_product');
    }
};
