<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'phone', 'birth', 'user_id', 'moipAccount'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
