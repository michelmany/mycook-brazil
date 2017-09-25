<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryData extends Model
{
    //
    protected $fillable = [
      'orderId',
      'address_id',
      'day',
      'fulldate',
      'time'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
