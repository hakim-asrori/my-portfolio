<?php

use App\Http\Controllers\API\ContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('contact')->group(function () {
    Route::post('/', [ContactController::class, 'store'])->name('api.contact.store');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('api.contact.index');
        Route::get('/{id}', [ContactController::class, 'show'])->name('api.contact.show');
        Route::delete('/trash/{id}', [ContactController::class, 'trash'])->name('api.contact.trash');
        Route::delete('/delete/{id}', [ContactController::class, 'delete'])->name('api.contact.delete');
    });
});
