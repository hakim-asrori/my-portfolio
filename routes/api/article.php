<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;

Route::prefix('article')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('api.article.index');
    Route::get('/{slug}', [ArticleController::class, 'show'])->name('api.article.show');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/', [ArticleController::class, 'store'])->name('api.article.store');
        Route::get('/{id}/edit', [ArticleController::class, 'edit'])->name('api.article.edit');
        Route::put('/{id}', [ArticleController::class, 'update'])->name('api.article.update');
        Route::delete('/trash/{id}', [ArticleController::class, 'trash'])->name('api.article.trash');
        Route::delete('/delete/{id}', [ArticleController::class, 'delete'])->name('api.article.delete');
    });
});
