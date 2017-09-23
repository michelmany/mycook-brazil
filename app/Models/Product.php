<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var array
     */
    protected $appends = ['photo_full_url'];

    /**
     * @var array
     */
    protected $fillable = [
        'seller_id', 'name', 'desc', 'serve', 'photo', 'price', 'comments'
    ];

    /**
     * @return null|string
     */
    public function getPhotoFullUrlAttribute()
    {
        if (isset($this->attributes['photo'])) {
            return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/products/' . $this->attributes['photo'];
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extras()
    {
        return $this->hasMany(ProductExtra::class);
    }
}
