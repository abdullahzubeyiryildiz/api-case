<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlbumController;
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

    Route::prefix('user')->group(function () {
        Route::get('/my-profile', [AuthController::class,'myProfile']);
        Route::post('/update/image', [AuthController::class,'updateUserImage']);
    });

    Route::get('artist/{artistID}/albums', [AlbumController::class, 'getAlbumsList']);
    Route::get('artist/{artistID}/genres', [AlbumController::class, 'getGenreList']);

});
