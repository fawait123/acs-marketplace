<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;


Route::get('/', [WelcomeController::class,'index'])->name('welcome');
Route::get('products', [WelcomeController::class,'products'])->name('frontend.product.index');
Route::get('product/{id}', [WelcomeController::class,'product'])->name('frontend.product.show');
