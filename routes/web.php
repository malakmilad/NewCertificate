<?php

use App\Http\Controllers\FontController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
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
        Route::get('group/export','export')->name('group.export');
    });
    Route::controller(TemplateController::class)->group(function(){
        Route::get('template/index','index')->name('template.index');
        Route::get('template/create','create')->name('template.create');
        Route::get('template/show/{template}','show')->name('template.show');
        // Route::get('template/edit/{template}','edit')->name('template.edit');
        Route::post('template/store','store')->name('template.store');
        Route::get('template/delete/{template}','destroy')->name('template.delete');
    });
});

require __DIR__.'/auth.php';
