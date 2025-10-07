<?php

namespace App\Models;

use Guiliredu\BrazilianCityMigrationSeed\Models\City;
use Guiliredu\BrazilianCityMigrationSeed\Models\State;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'state_id', 'city_id', 'middle_id', 'name', 'description', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /** Relations */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function middle()
    {
        return $this->belongsTo(Middle::class);
    }
}
