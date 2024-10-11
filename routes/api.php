<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
 
Route::middleware('auth:api')->group( function () {
    Route::get('user', [UserController::class, 'userRecord']);
});
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/