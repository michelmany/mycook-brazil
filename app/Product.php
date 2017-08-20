<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_full_url'];

    protected $fillable = [
        'seller_id', 'name', 'desc', 'serve', 'photo', 'price'
    ];

    public function getPhotoFullUrlAttribute()
    {
        if (!isset($this->attributes['photo'])) {
            return null;
        }
        return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/products/' . $this->attributes['photo'];
    }

    public function extras() {
        return $this->hasMany(ProductExtra::class);
    }
}
