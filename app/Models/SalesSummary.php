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
        return $this->hasMany(Stock::class, 'summary_id')->where('action', 'export');
    }


    function client()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
