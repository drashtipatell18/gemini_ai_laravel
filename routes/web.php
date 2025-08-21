<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;


Route::get('/login', [LoginController::class, 'Login'])->name('login');
Route::post('/loginStore', [LoginController::class, 'LoginStore'])->name('loginstore');
Route::get('/signup', [LoginController::class, 'Signup'])->name('signup');

Route::post('/signupStore', [LoginController::class, 'SignupStore'])->name('signupStore');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('upgrade', [HomeController::class, 'Upgrade'])->name('upgrade');