<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasApiTokens, HasFactory;
    use HasUuids;

    protected $fillable = [
        'artist_id',
        'name',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

}
