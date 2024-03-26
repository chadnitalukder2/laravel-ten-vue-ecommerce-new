<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->latest();;
    }
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
 
}
