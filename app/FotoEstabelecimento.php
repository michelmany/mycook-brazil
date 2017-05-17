<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoEstabelecimento extends Model
{
    protected $table = 'fotos_estabelecimentos';
    protected $fillable = [
        'url', 'order', 'seller_id'
    ];
    public $timestamps = false;
}
