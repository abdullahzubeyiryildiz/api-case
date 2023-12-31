<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
class Track extends Model
{
    use HasApiTokens, HasFactory;
    use HasUuids;
    protected $fillable = [
        'id',
        'artist_id',
        'album_id',
        'name',
        'popularity',
        'track_number',
        'uri',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

}
