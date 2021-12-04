<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController,
    App\Http\Controllers\AuthorController;

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

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('homepage');

Route::resource('knihy', BookController::class);
Route::post('books/update-is-borrowed/{knihy}', [BookController::class, 'updateBorrowed'])->name('books.update_borrowed');
Route::post('books/filter', [BookController::class, 'index'])->name('books.filter');

Route::resource('autori', AuthorController::class);
