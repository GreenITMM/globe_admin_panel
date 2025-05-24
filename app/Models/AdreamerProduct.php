<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdreamerProduct extends Model
{
    use HasFactory, HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category() {
        return $this->belongsTo(AdreamerCategory::class, 'adreamer_category_id');
    }

    public function images() {
        return $this->hasMany(AdreamerProductImage::class);
    }

    public function attributes() {
        return $this->belongsToMany(AdreamerAttribute::class);
    }

    public function variations() {
        return $this->hasMany(AdreamerProductVariation::class);
    }
}
