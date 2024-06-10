<?php

use App\Http\Controllers\FontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(FontController::class)->group(function(){
        Route::get('font/index','index')->name('font.index');
        Route::get('font/create','create')->name('font.create');
        Route::post('font/store','store')->name('font.store');
    });
});

require __DIR__.'/auth.php';
