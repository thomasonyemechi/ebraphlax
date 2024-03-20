<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $guarded;


    function summary()
    {
        return $this->belongsTo(SalesSummary::class, 'sales_summary');
    }


}
