<?php

use App\Http\Controllers\DefaultsController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("register", [RegisterController::class, "register"]);
Route::get("users/{id}", [UsersController::class, "getById"]);
Route::get("users", [UsersController::class, "getAll"]);

Route::post("loan", [LoansController::class, "create"]);
Route::get("loan/get-by-user/{id}", [LoansController::class, "getByUser"]);
Route::get("loan/get-by-id/{id}", [LoansController::class, "getById"]);
Route::delete("loan/{id}", [LoansController::class, "delete"]);
Route::put("loan/{id}", [LoansController::class, "update"]);


Route::get("states", [DefaultsController::class, "getStates"]);
Route::get("cities/{id}", [DefaultsController::class, "getCitiesByState"]);
Route::get("marital-status", [DefaultsController::class, "maritalStatus"]);
Route::get("loan-modalities", [DefaultsController::class, "loanModality"]);


Route::get("ini", function () {
    return phpinfo();
});
