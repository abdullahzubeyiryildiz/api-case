<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;


    protected $fillable = [
        'track_id',
        'name',
        'total_tracks',
        'uri',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public static function createWithTrack($track, $attributes)
    {
        return $track->albums()->create($attributes);
    }
}
