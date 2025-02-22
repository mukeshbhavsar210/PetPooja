<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;

    function toggleActive() {
        $this->active!=(int)$this->active;
        return $this;
    }
}
