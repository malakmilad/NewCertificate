<?php

use App\Http\Controllers\FontController;
use App\Http\Controllers\GroupController;
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
        Route::get('font/delete/{font}','destroy')->name('font.delete');
    });
    Route::controller(GroupController::class)->group(function(){
        Route::get('group/index','index')->name('group.index');
        Route::get('group/create','create')->name('group.create');
        Route::get('group/show/{group}','show')->name('group.show');
        Route::post('group/store','store')->name('group.store');
        Route::get('group/delete/{group}','destroy')->name('group.delete');
        Route::get('group/export','export')->name('group.export');
    });
});

require __DIR__.'/auth.php';
