<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
//use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductDeleteController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);

// Search product form view route
Route::get('/mekle', [ProductController::class, 'searchFormView'])->name('mekle');
// Search product form submission route
Route::post('/mekle', [ProductController::class, 'searchProduct']);


// Route to show the add product form
Route::get('/pievieno', function () {
    return view('pievieno');
})->name('pievieno');
// Route to handle form submission from pievieno.blade.php
Route::post('/submit', [ProductController::class, 'submitProduct']);


Route::get('/dzest', function ()
{
    return view('dzest');
})->name('dzest');
Route::get('/delete-product', [ProductController::class, 'searchFormView'])->name('delete.product.form');
Route::post('/delete-product', [ProductController::class, 'deleteProduct'])->name('delete.product');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'index']);

