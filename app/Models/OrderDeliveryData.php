<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryData extends Model
{
    //
    protected $fillable = [
      'orderId',
      'day',
      'fulldate',
      'time'
    ];
}
