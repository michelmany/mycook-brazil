<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep', 'address', 'number', 'complement', 'neighborhood', 'city', 'state', 'longitude', 'latitude', 'user_id', 'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
