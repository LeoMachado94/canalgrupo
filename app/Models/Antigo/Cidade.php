<?php

namespace App\Models\Antigo;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'cidade';
    protected $primaryKey = 'CODCIDADE';
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

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'CODUF', 'CODESTADO');
    }
}
