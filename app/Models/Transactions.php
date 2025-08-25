<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    
     protected $fillable = [
        'title',
        'type',
        'amount',
        'date',
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }
}
