<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use SerializesDatesAsDatabaseFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'vehicle_id', 'title', 'hour', 'responsible', 'description', 'active'
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
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getHourAttribute($value)
    {
        if (empty($hour)) return null;
        $hour = Carbon::createFromFormat('H:i:s', $value);
        return $hour->format('H:i');
    }
}
