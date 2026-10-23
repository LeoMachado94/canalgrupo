<?php

namespace App\Models\Antigo;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'veiculos';
    protected $primaryKey = 'CODVEICULO';
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

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'CODCIDADE', 'CODCIDADE');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'CODUF', 'CODESTADO');
    }
}
