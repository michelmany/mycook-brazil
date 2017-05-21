<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar_full_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cpf', 'avatar',  'active',  'role', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarFullUrlAttribute()
    {
        if (!isset($this->attributes['avatar'])) {
            return null;
        }
        if (!$this->attributes['avatar']) {
            $avatar = md5($this->attributes['email']);
            return 'https://secure.gravatar.com/avatar/'. $avatar.'?200';
        }
        return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/avatar/' . $this->attributes['avatar'];
    }

    public function buyer() {
        return $this->hasOne(Buyer::class);
    }

    public function seller() {
        return $this->hasOne(Seller::class);
    }

    public function addresses() {
        return $this->hasMany(Address::class);
    }
}
