<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiArtifactController;
use App\Http\Controllers\Api\ApiImageController;
use App\Http\Controllers\Api\ApiPersonController;
use App\Http\Controllers\Api\ApiUserController;

//Route::post('register', [UserController::class, 'register']);
 
    Route::post('register', [UserController::class, 'register']);
    Route::get('/persons', [ApiPersonController::class, 'index']);
    Route::get('/artifacts', [ApiArtifactController::class, 'index']);
    Route::delete('/images/{id}/delete', [ApiImageController::class, 'delete']);
    Route::get('/images', [ApiImageController::class, 'index']);
    Route::get('/apiusers', [ApiUserController::class, 'index']);
    Route::get('/artifacts/{id}/delete', [ApiArtifactController::class, 'delete']);

Route::middleware('auth:api')->group( function () {
    Route::get('user', [UserController::class, 'userRecord']);
    Route::get('users', [UserController::class, 'userRecords']);
//    Route::get('/artifacts', [ArtifactController::class, 'index']);
});
Route::group(['middleware' => ['client']], function() {
    Route::post('login', [UserController::class, 'login']);
});
Route::group(['middleware' => ['client', 'auth:api']], function() {
//Route::middleware(['client'])->group(function () {
    Route::get('/artifactstest', [ApiArtifactController::class, 'index']);
            Log::error('in clinet ??middlewate');

//    Route::get('/artifacts', [ApiArtifactController::class, 'index']);
    Route::get('/artifacts/{id}', [ApiArtifactController::class, 'show']);
    //Route::delete('/artifacts/{id}/delete', [ApiArtifactController::class, 'delete']);

    Route::post('/artifacts', [ApiArtifactController::class, 'store']);
    Route::post('/artifacts/store', [ApiArtifactController::class, 'store']);

});


//Route::get('/artifacts/{id}', 'ArtifactController@show');
//Route::post('/artifacts', 'ArtifactController@store');
//Route::delete('/artifacts/{id}', 'ArtifactController@delete');
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/