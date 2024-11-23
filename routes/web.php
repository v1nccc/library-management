<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

Route::resource('/', BookController::class);
Route::resource('books', BookController::class);
Route::resource('customers', CustomerController::class);
Route::resource('categories', CategoryController::class);
