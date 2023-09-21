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
        'id',
        'artist_id',
        'name',
        'popularity',
        'track_number',
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

}
