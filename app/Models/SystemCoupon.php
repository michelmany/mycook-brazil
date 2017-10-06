<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemCoupon extends Model
{
    //
    protected $fillable = [
        'code',
        'uses',
        'settings',
        'expires_in'
    ];

    protected $casts = [
        'settings' => 'collection'
    ];

    protected $dates = [
        'expires_in'
    ];
}
