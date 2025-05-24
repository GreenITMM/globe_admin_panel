<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class XpPenProduct extends Model
{
    use HasFactory, HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function series() {
        return $this->belongsTo(XpPenSeries::class);
    }

    public function category() {
        return $this->belongsTo(XpPenCategory::class);
    }

    public function images() {
        return $this->hasMany(XpPenImage::class);
    }

}
