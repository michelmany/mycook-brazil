<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoEstabelecimento extends Model
{
    protected $table = 'fotos_estabelecimentos';
    protected $appends = ['full_url'];
    protected $fillable = [
        'url', 'order', 'seller_id'
    ];
    public $timestamps = false;

    public function getFullUrlAttribute()
    {
        return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/products/' . $this->attributes['url'];
    }
}
