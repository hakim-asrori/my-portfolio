<?php

use App\Http\Controllers\API\Auth\CheckController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)->name('api.auth.login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('check', CheckController::class)->name('api.auth.check');
        Route::post('logout', LogoutController::class)->name('api.auth.logout');
    });
});
