<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function product_variation() {
        return $this->belongsTo(ProductVariation::class);
    }

    public function xp_pen_product() {
        return $this->belongsTo(XpPenProduct::class);
    }

    public function solar_product() {
        return $this->belongsTo(SolarProduct::class);
    }

    public function solar_product_variation() {
        return $this->belongsTo(SolarProductVariation::class);
    }

    public function adreamer_product() {
        return $this->belongsTo(AdreamerProduct::class);
    }

    public function adreamer_product_variation() {
        return $this->belongsTo(AdreamerProductVariation::class);
    }
}
