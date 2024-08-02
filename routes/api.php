<?php

use App\Http\Controllers\LoansController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("register", [RegisterController::class, "register"]);
Route::get("users/{id}", [UsersController::class, "getById"]);

Route::post("loan", [LoansController::class, "create"]);
Route::get("loan/get-by-user/{id}", [LoansController::class, "getByUser"]);
Route::get("loan/get-by-id/{id}", [LoansController::class, "getById"]);
Route::delete("loan/{id}", [LoansController::class, "delete"]);
