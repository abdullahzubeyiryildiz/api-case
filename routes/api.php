<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpotifyController;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
});

Route::middleware(['auth:api'])->group(function(){
    Route::get('/auth/my-profile', [AuthController::class,'myProfile']);
    Route::post('/auth/change/foto', [AuthController::class,'changeFoto']);


    Route::prefix('spotify')->group(function () {
        Route::get('/artist', [SpotifyController::class,'getArtistList']);
        Route::get('/album', [SpotifyController::class,'getTracksList']);

    });
});
