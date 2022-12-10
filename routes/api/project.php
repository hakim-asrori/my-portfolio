<?php

use App\Http\Controllers\API\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('api.project.index');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('api.project.show');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [ProjectController::class, 'store'])->name('api.project.store');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('api.project.update');
        Route::delete('/trash/{id}', [ProjectController::class, 'trash'])->name('api.project.trash');
        Route::delete('/delete/{id}', [ProjectController::class, 'delete'])->name('api.project.delete');
    });
});
