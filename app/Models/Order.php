<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'orderId',
        'seller_id',
        'buyer_id',
        'status',
        'items',
        'amount',
        'payment',
        '_links'
    ];

    protected $casts = [
      'items' => 'collection',
      'amount' => 'collection',
      'payment' => 'collection',
      '_links' => 'collection'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seller()
    {
        return $this->hasOne(Seller::class, 'id', 'seller_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'id', 'buyer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(OrderDeliveryData::class);
    }
}
