<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Route::group(['middleware' => 'admin'], function() {
//    Route::get('admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin');
//});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('db', \App\Http\Controllers\DataBaseController::class);
    Route::resource('ds', \App\Http\Controllers\DataSourceController::class);
    Route::resource('dsf', \App\Http\Controllers\DataSourceFieldController::class);
    Route::resource('dsa', \App\Http\Controllers\DataSourceAccessController::class);
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class,
    'index'])->name('admin');
Route::get('/admin/remotes/{srv}', [App\Http\Controllers\Admin\AdminController::class,
    'remote'])->name('remotes');
Route::get('/admin/remotes/{srv}/{project_key}', [App\Http\Controllers\Admin\AdminController::class,
    'remote_project'])->name('remote_project');
