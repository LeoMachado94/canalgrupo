<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;
use function foo\func;

class ClippingFile extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'clipping_has_files';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'clipping_id', 'file_type', 'path', 'name', 'extension', 'size'
    ];

    protected $appends = [
        'type',
        'badge_color',
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

    public function clipping()
    {
        return $this->belongsTo(Clipping::class);
    }

    public function getTypeAttribute()
    {
        $ext = $this->getAttribute('extension');
        switch ($ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $type = 'Imagem';
                break;
            case 'ogg':
            case 'mp3':
            case 'wav':
                $type = 'Áudio';
                break;
            case 'mp4':
            case 'mkv':
            case 'webm':
                $type = 'Vídeo';
                break;
            case 'doc':
            case 'docx':
            case 'xls':
            case 'xlsx':
            case 'ppt':
            case 'pptx':
            case 'pdf':
            case 'txt':
                $type = 'Documento';
                break;
            default:
                $type = 'Indefinido';
        }
        return $type;
    }

    public function getBadgeColorAttribute()
    {
        $type = $this->getTypeAttribute();
        $colors = [
            'Imagem' => 'bg-yellow',
            'Vídeo' => 'bg-green text-white',
            'Áudio' => 'bg-blue text-white',
            'Documento' => 'bg-dark text-white',
            'Indefinido' => 'bg-secondary'
        ];
        return $colors[$type];
    }

}
