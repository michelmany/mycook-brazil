<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemCategory extends Model
{
    protected $fillable = ['name', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products()
    {
        return $this->belongsTo(Product::class, 'id', 'category_id');
    }
}
