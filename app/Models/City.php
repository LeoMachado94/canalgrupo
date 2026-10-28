<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

// Moved in from guiliredu/laravel-seed-migration-estados-cidades-brasil (MIT, abandoned, PHP 7 only).
class City extends Model
{
    use SerializesDatesAsDatabaseFormat;

    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
