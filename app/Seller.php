<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'phone', 'phone2', 'phone3', 'phone4', 'phone5', 'formacao', 'facebook', 'instagram', 'type_delivery',
        'distance_delivery', 'score', 'plates_quantity', 'user_id', 'type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
