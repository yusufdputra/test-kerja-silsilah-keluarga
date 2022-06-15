<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
Route::post('insert', [App\Http\Controllers\SilsilahController::class, 'insert'])->name('insert');
