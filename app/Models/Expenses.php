<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $guarded;

    function category()
    {
        return $this->belongsTo(Expenses::class, 'category_id');
    }

    function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

}
