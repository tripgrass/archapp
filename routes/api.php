<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiArtifactController;

//Route::post('register', [UserController::class, 'register']);
 
    Route::get('/artifactstest', [ApiArtifactController::class, 'index']);
    Route::post('register', [UserController::class, 'register']);

Route::middleware('auth:api')->group( function () {
    Route::get('user', [UserController::class, 'userRecord']);
    Route::get('users', [UserController::class, 'userRecords']);
//    Route::get('/artifacts', [ArtifactController::class, 'index']);
});
Route::middleware(['client'])->group(function () {
            Log::error('in clinet ??middlewate');

    Route::get('/artifacts', [ApiArtifactController::class, 'index']);

    Route::post('/artifacts', [ApiArtifactController::class, 'store']);
    Route::post('/artifacts/store', [ApiArtifactController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);

});
Route::group(['middleware' => ['client','auth:sanctum']], function() {
//Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/artifacts/{id}', [ApiArtifactController::class, 'show']);
    Route::get('/posts', [PostController::class, 'index'])->middleware('role:admin|viewer');
    Route::post('/posts', [PostController::class, 'store'])->middleware('role:admin|author');
    Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('role:admin');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('role:admin');
    Route::get('/posts/{post}', [PostController::class, 'show'])->middleware('role:admin|viewer');
});
//Route::get('/artifacts/{id}', 'ArtifactController@show');
//Route::post('/artifacts', 'ArtifactController@store');
//Route::delete('/artifacts/{id}', 'ArtifactController@delete');
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/