<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use App\Models\AdreamerCategory;
use Spatie\Sluggable\SlugOptions;
use App\Models\SolarProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolarProduct extends Model
{
    use HasFactory, HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category() {
        return $this->belongsTo(SolarCategory::class, 'solar_category_id');
    }

    public function images() {
        return $this->hasMany(SolarProductImage::class);
    }

    public function attributes() {
        return $this->belongsToMany(SolarAttribute::class);
    }

    public function variations() {
        return $this->hasMany(SolarProductVariation::class);
    }
}
