<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'phone', 'phone2', 'phone3', 'phone4', 'phone5', 'formacao', 'facebook', 'instagram', 'type_delivery',
        'distance_delivery', 'score', 'plates_quantity', 'user_id', 'type_id', 'dishes'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * @param $value
     */
    protected function setTypeDeliveryAttribute($value)
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        $this->attributes['type_delivery'] = $value;
    }

    /**
     * @return array
     */
    protected function getTypeDeliveryAttribute()
    {
        $data = explode(',', $this->attributes['type_delivery']);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fotos()
    {
        return $this->hasMany(FotoEstabelecimento::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
