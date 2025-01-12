<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    public function seating(){
        return $this->hasMany(Seating::class);
    }

    public function menu(){
        return $this->hasMany(Menu::class);
    }

    public function seat(){
        return $this->belongsTo(Seating::class);
    }
}
