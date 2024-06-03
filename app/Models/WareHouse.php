<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;


    function stocks()
    {
        return $this->hasMany(Cstock::class, 'warehouse_id');
    }
}
