<?php

namespace App;

use App\Models\Address;
use App\Models\Buyer;
use App\Models\Moip\MoipSeller;
use App\Models\Seller;
use App\Models\Social;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $appends = ['avatar_full_url'];

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'cpf', 'avatar',  'active',  'role', 'email', 'password',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return null|string
     */
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

    /**
     * @return string
     */
    public function getSlugAttribute()
    {
        return str_slug($this->name);
    }

    /**
     * @return string
     */
    public function getCityAttribute()
    {
        return str_slug($this->addresses[0]->city . '-' . $this->addresses[0]->state);
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return action('FrontendController@singleChef', [$this->id, $this->city, $this->slug]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buyer() {
        return $this->hasOne(Buyer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seller() {
        return $this->hasOne(Seller::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses() {
        return $this->hasMany(Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function social() {
        return $this->hasOne(Social::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function moipseller()
    {
        return $this->hasOne(MoipSeller::class);
    }
}
