<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'phone', 'birth', 'user_id', 'moipAccount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
