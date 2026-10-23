<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use SerializesDatesAsDatabaseFormat;

    protected $table = 'client_has_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'client_id', 'email',
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
}
