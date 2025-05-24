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
        Schema::create('adreamer_attribute_adreamer_product', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('adreamer_attribute_id');
            $table->unsignedBigInteger('adreamer_product_id');

            // Custom short constraint names
            $table->foreign('adreamer_attribute_id', 'aaap_attr_fk')
                  ->references('id')->on('adreamer_attributes')
                  ->onDelete('cascade');

            $table->foreign('adreamer_product_id', 'aaap_prod_fk')
                  ->references('id')->on('adreamer_products')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adreamer_attribute_adreamer_product');
    }
};
