<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExtra extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'date', 'start_time', 'end_time', 'quantity'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
