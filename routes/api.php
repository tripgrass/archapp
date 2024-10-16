<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiArtifactController;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
 

Route::middleware('auth:api')->group( function () {
    Route::get('user', [UserController::class, 'userRecord']);
    Route::get('users', [UserController::class, 'userRecords']);
//    Route::get('/artifacts', [ArtifactController::class, 'index']);
});
Route::middleware(['client'])->group(function () {
    Route::get('/artifacts', [ApiArtifactController::class, 'index']);

    Route::post('/artifacts', [ApiArtifactController::class, 'store']);
});

//Route::get('/artifacts/{id}', 'ArtifactController@show');
//Route::post('/artifacts', 'ArtifactController@store');
//Route::delete('/artifacts/{id}', 'ArtifactController@delete');
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/