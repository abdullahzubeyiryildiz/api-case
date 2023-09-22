<?php

namespace App\Http\Controllers;

use  Spotify;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Artist;
use App\Mail\MailTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\GenceResource;

class WebTestController extends Controller
{

    public function test() {

    }

}
