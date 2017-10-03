<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryData extends Model
{
    //
    protected $fillable = [
      'order_id',
      'address_id',
      'day',
      'fulldate',
      'time'
    ];

    protected $dates = [
        'time'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
