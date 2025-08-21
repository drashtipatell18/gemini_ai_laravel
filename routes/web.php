<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('index', [HomeController::class, 'index'])->name('index');
Route::get('upgrade', [HomeController::class, 'Upgrade'])->name('upgrade');