<?php

use App\Http\Controllers\StuntingPredictionController;
use Illuminate\Support\Facades\Route;

// Landing page publik
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('stunting', StuntingPredictionController::class);
});

require __DIR__.'/auth.php';