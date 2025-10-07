<?php

namespace App\Models;

use App\Notifications\ClientResetPasswordNotification;
use Guiliredu\BrazilianCityMigrationSeed\Models\City;
use Guiliredu\BrazilianCityMigrationSeed\Models\State;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Client extends Authenticatable
{
    use Notifiable;
    protected $guard = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'cnpj', 'state_id', 'city_id', 'contact', 'email', 'password', 'logo', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /** Relations */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /** Relations */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getLogoAttribute($value)
    {
//        if (empty($value) || !file_exists(public_path($value))) {
//            return 'assets/images/no_image.png';
//        }
        return $value;
    }

    public function getLogo()
    {
        if ($this->logo) {
            return Storage::disk('spaces')->url($this->logo);
//            return asset($this->logo);
        }
        return asset('assets/images/no_user_image.svg');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPasswordNotification($token));
    }
}
