<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'longitude',
        'latitude',
        'name',
        'user_id',
        'default'
    ];

    protected $casts = [
        'default' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
