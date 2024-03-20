<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockSummary extends Model
{
    use HasFactory;

    protected $guarded;


    function restocks()
    {
        return $this->hasMany(Restock::class, 'summary_id');
    }


    function expenses()
    {
        return $this->hasMany(Expenses::class, 'summary_id');
    }
}
