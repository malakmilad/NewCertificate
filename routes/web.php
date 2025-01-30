<?php

use App\Http\Controllers\FontController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupTemplateController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('scan/{id}/{course_id}/{template_id}', [ScanController::class, 'scan']);
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(FontController::class)->group(function () {
        Route::get('font/index', 'index')->name('font.index');
        Route::get('font/create', 'create')->name('font.create');
        Route::post('font/store', 'store')->name('font.store');
        Route::delete('font/delete/{font}', 'destroy')->name('font.delete');
    });
    Route::controller(GroupController::class)->group(function () {
        Route::get('group/index', 'index')->name('group.index');
        Route::get('group/create', 'create')->name('group.create');
        Route::get('group/show/{group}', 'show')->name('group.show');
        Route::get('group/edit/{group}', 'edit')->name('group.edit');
        Route::put('group/update/{group}', action: 'update')->name('group.update');
        Route::delete('group/delete/{group}', 'destroy')->name('group.delete');
        Route::post('group/store', 'store')->name('group.store');
        Route::get('group/export', 'export')->name('group.export');
    });
    Route::controller(TemplateController::class)->group(function () {
        Route::get('template/index', 'index')->name('template.index');
        Route::get('template/create', 'create')->name('template.create');
        Route::get('template/show/{template}', 'show')->name('template.show');
        // Route::get('template/edit/{template}','edit')->name('template.edit');
        Route::post('template/store', 'store')->name('template.store');
        Route::delete('template/delete/{template}', 'destroy')->name('template.delete');
    });
    Route::controller(GroupTemplateController::class)->group(function () {
        Route::get('generate/index', 'index')->name('generate.index');
        Route::get('generate/create', 'create')->name('generate.create');
        Route::get('generate/show/{id}/{course_id}/{template_id}', 'show')->name('generate.show');
        Route::get('generate/download/{id}/{course_id}/{template_id}', 'download')->name('generate.download');
        Route::post('generate/store', 'store')->name('generate.store');
    });
    Route::controller(StudentController::class)->group(function(){
        Route::post('student/store','store')->name('student.store');
    });
});

require __DIR__ . '/auth.php';
