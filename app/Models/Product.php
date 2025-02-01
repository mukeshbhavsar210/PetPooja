<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }

    public function seat(){
        return $this->hasMany(Seat::class);
    }

    public function image(){
        return $this->belongsTo(ProductImage::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

}
