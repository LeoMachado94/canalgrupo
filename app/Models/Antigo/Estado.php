<?php

namespace App\Models\Antigo;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'estado';
    protected $primaryKey = 'CODESTADO';
    protected $connection = 'origin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
}
