<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

// Moved in from guiliredu/laravel-seed-migration-estados-cidades-brasil (MIT, abandoned, PHP 7 only).
class State extends Model
{
    use SerializesDatesAsDatabaseFormat;

    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
