<?php

namespace App\Models\Moip;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MoipSeller extends Model
{
    protected $fillable = [
        'moipAccount', 'data'
    ];

    protected $casts = [
        'data' => 'collection'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function publicKeys()
    {
        return $this->hasOne(MoipSellerPublicKey::class);
    }
}
