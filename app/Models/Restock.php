<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    use HasFactory;

    protected $guarded;


    function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }



    
}
