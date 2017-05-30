<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'phone', 'phone2', 'phone3', 'phone4', 'phone5', 'formacao', 'facebook', 'instagram', 'type_delivery',
        'distance_delivery', 'score', 'plates_quantity', 'user_id', 'type_id', 'dishes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function setTypeDeliveryAttribute($value)
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        $this->attributes['type_delivery'] = $value;
    }

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

    public function fotos() {
        return $this->hasMany(FotoEstabelecimento::class);
    }
}
