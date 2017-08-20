<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductExtra extends Model
{
    protected $fillable = [
        'product_id', 'date', 'start_time', 'end_time', 'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
