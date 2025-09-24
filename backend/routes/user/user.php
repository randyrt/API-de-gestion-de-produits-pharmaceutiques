<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;


Route::get('/user', [UserController::class, 'index'])->name('user.index');




