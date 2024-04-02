<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuteBag extends Model
{
    use HasFactory;


    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }



    public function client()
    {
        if($this->client_type == 'supplier') {
            return $this->belongsTo(Supplier::class, 'client_id');
        }else {
            return $this->belongsTo(Customer::class, 'client_id');
        }
    }

}
