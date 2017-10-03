<?php

namespace App\Models\Moip;

use Illuminate\Database\Eloquent\Model;

class MoipSellerPublicKey extends Model
{
    protected $fillable = [
      'data'
    ];

    protected $casts = [
        'data' => 'collection'
    ];
}
