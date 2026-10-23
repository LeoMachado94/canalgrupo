<?php

namespace App\Models\Antigo;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'arquivos';
    protected $primaryKey = 'CODARQUIVO';
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
