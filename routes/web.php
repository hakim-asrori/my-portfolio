<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/{any}', function () {
    return view('auth');
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!auth).*$');

// Route::get('admin', function () {
//     return view('app');
// });
