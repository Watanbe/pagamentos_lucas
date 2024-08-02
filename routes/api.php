<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("register", [RegisterController::class, "register"]);
Route::get("users/{id}", [UsersController::class, "getById"]);
