<?php

namespace App\Models;


use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends Model
{
    use HasApiTokens, HasFactory;
    use HasUuids;

    protected $fillable = [
        'id',
        'name',
    ];


    public function albums()
    {
        return $this->hasMany(Album::class);
    }


    public function gences()
    {
        return $this->hasMany(Genre::class);
    }

}
