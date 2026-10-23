<?php

namespace App\Models;

use App\Models\Concerns\SerializesDatesAsDatabaseFormat;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Clipping extends Model
{
    use Sluggable, SerializesDatesAsDatabaseFormat;

    public static function boot() {
        parent::boot();
    }

    public static $skipMutators = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                // eloquent-sluggable 6 started duplicate suffixes at -1; newer versions start at -2.
                'firstUniqueSuffix' => 1,
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'client_id', 'middle_id', 'subject_matter_id', 'vehicle_id', 'editorial_id', 'user_id',
        'classification_id', 'exhibition_id', 'source_id', 'title', 'slug', 'date', 'last_read', 'review',
        'active', 'is_favorite', 'created_at', 'updated_at'
    ];

    /**
     * Get appends attributes
     *
     * @var array
     */
    protected $appends = [
        'created'
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

    /* Relations */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function middle()
    {
        return $this->belongsTo(Middle::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function subject()
    {
        return $this->belongsTo(SubjectMatter::class, 'subject_matter_id');
    }

    public function files()
    {
        return $this->hasMany(ClippingFile::class);
    }

    /* Appends, Mutators, Accessors */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($value)
    {
        if (in_array('date', self::$skipMutators)) {
            return $value;
        }

        if (empty($value)) return null;
        $date = Carbon::createFromFormat('Y-m-d', $value);
        return $date->format('d/m/Y');
    }

    public function getCreatedAttribute($value)
    {
        if (in_array('created', self::$skipMutators)) {
            $created = Carbon::createFromFormat('Y-m-d H:i:s', $this->getAttribute('created_at'));
            return $created->format('Y-m-d');
        }

        if (empty($this->getAttribute('created_at'))) return null;
        $created = Carbon::createFromFormat('Y-m-d H:i:s', $this->getAttribute('created_at'));
        return $created->format('d/m/Y');
    }

    public function lastRead()
    {
        if (!empty($this->getAttribute('last_read'))) {
            $last = Carbon::createFromFormat('Y-m-d H:i:s', $this->getAttribute('last_read'));
            return $last->format('d/m/Y - H:i');
        }
        return $this->getAttribute('created_at')->format('d/m/Y - H:i');
    }

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }
}
