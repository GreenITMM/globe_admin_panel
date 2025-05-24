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
        Schema::create('xp_pen_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->foreignId('category_id')->constrained('xp_pen_categories')->onDelete('cascade');
            $table->foreignId('series_id')->constrained('xp_pen_series')->onDelete('cascade');
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
        Schema::dropIfExists('xp_pen_products');
    }
};
