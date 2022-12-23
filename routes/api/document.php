<?php

use App\Http\Controllers\API\DocumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('document')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('api.document.index');
    Route::delete('/{id}', [DocumentController::class, 'trash'])->name('api.document.trash');
});
