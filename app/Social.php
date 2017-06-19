<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'user_id', 'provider_user_id', 'provider'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
