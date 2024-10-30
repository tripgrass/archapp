<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\EloController;
use App\Http\Controllers\ImageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('artifacts', ArtifactController::class);

Route::get('/compare', function (){
    return view('compare');
});
Route::get('/compare/{id}', function (Request $request, string $id){
    return view('compare',['artifact_id' => $id]);
});

Route::get('/compare-summary', function (){
    return view('compare-summary');
});
Route::get('/compare-visual', function (){
    return view('compare-visual');
});
Route::resource('elo', EloController::class);
  
Route::get('image-upload', [ImageController::class, 'index']);
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
