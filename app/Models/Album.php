<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasApiTokens, HasFactory;
    use HasUuids;

    protected $fillable = [
        'artist_id',
        'name',
        'total_tracks',
        'uri',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public static function createWithTrack($track, $attributes)
    {
        $album = new Album($attributes);
        $album->uuid = (string) Str::uuid();
        $track->albums()->save($album);
        return $album;
    }
}
