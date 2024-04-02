<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cstock extends Model
{
    use HasFactory;

    protected $guarded;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }


    
    public function client()
    {
        if($this->action == 'import') {
            return $this->belongsTo(Supplier::class, 'client_id');
        }else {
            return $this->belongsTo(Customer::class, 'client_id');
        }
    }

}
