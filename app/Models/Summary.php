<?php

namespace App\Models;

use Carbon\Carbon;
use Guiliredu\BrazilianCityMigrationSeed\Models\City;
use Guiliredu\BrazilianCityMigrationSeed\Models\State;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'title', 'date', 'file'
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
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($value)
    {
        return Carbon::create($value)->format('d/m/Y');
    }
}
