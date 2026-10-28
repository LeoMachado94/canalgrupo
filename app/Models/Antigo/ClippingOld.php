<?php

namespace App\Models\Antigo;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;
use App\Models\Antigo\Assunto;

class ClippingOld extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'clippings';
    protected $primaryKey = 'CODCLIPPING';
    protected $connection = 'origin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CODCLIPPING', 'CODCLIENTE', 'CODASSUNTO', 'DATA', 'AREA', 'TITULO', 'TIPO', 'CADERNO', 'PAGINA', 'MEIO',
        'CODVEICULO', 'CODEDITORIAL', 'EXIBICAO', 'RESENHA', 'COMENTARIO', 'LIBERADO', 'USUARIO', 'DTCADASTRO',
        'DTLIBERADO', 'USUARIOLIB', 'INATIVO'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function assunto()
    {
        return $this->belongsTo(Assunto::class, 'CODASSUNTO', 'CODASSUNTO');
    }
}
