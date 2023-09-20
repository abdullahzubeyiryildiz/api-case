<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'popularity',
        'track_number',
        'uri',
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public static function findOrCreateByName($name, $attributes)
    {
        return static::updateOrCreate(
            ['name' => $name],
            $attributes
        );
    }
}
