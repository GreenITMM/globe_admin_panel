<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhishList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_type', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->morphTo(null, 'product_type', 'product_id');
    }
}
