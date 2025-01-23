<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function orders(){
        return $this->belongsTo(Order::class, 'order_id', );
    }

    protected $fillable = ['order_id', 'product_id', 'name', 'qty', 'price', 'total'];

}
