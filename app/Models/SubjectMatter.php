<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubjectMatter extends Model
{
    use SerializesDatesAsDatabaseFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'client_id', 'user_id', 'title', 'active', 'created_at', 'updated_at'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
