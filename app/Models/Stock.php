<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded;

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function sales()
    {
        $this->hasOne(Sales::class, 'summary_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        if($this->action == 'import') {
            return $this->belongsTo(Supplier::class, 'supplier_id');
        }else {
            return $this->belongsTo(Customer::class, 'customer_id');
        }
    }

    
}
