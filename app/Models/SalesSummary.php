<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesSummary extends Model
{
    use HasFactory;

    protected $guarded;

    function sales()
    {
        return $this->hasMany(Sales::class, 'summary_id');
    }
}
